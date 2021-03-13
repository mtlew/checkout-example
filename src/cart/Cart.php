<?php
declare(strict_types=1);


namespace app\modules\cart\src\cart;


use app\modules\cart\factory\receipt\ReceiptFactory;
use app\modules\cart\src\cart\_base\Discountable;
use app\modules\cart\src\receipt\Receipt;

class Cart extends Discountable
{

    protected $factoryReceipt;

    protected $productList;
    protected $deliveryList;
    protected $paymentList;
    protected $promocode;
    protected $fields;

    /** @var Receipt|null */
    protected $receipt;


    public function __construct(
        ReceiptFactory $factoryReceipt,

        CartProductList $productList,
        CartDeliveryList $deliveryList,
        CartPaymentList $paymentList,
        ?CartPromocode $promocode,
        array $fields
    ) {
        $this->factoryReceipt = $factoryReceipt;

        $this->productList = $productList;
        $this->deliveryList = $deliveryList;
        $this->paymentList = $paymentList;
        $this->promocode = $promocode;
        $this->fields = $fields;

        $this->init();
    }

    public function getProductList(): CartProductList
    {
        return $this->productList;
    }

    public function getDeliveryList(): CartDeliveryList
    {
        return $this->deliveryList;
    }

    public function getPaymentList(): CartPaymentList
    {
        return $this->paymentList;
    }

    public function getDelivery(): ?CartDelivery
    {
        return $this->deliveryList->getItemSelected();
    }

    public function getPayment(): ?CartPayment
    {
        return $this->paymentList->getItemSelected();
    }

    public function getPromocode(): ?CartPromocode
    {
        return $this->promocode;
    }

    /**
     * @return IOrderFormFieldsEntity[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function getReceipt(): ?Receipt
    {
        return $this->receipt;
    }

    public function getDiscountWithoutDelivery(): int
    {
        if ($this->getDelivery()) {
            return parent::getDiscount() - $this->getDelivery()->getDiscount();
        }

        return parent::getDiscount();
    }

    protected function init(): void
    {
        $this->receipt = $this->receiptCreate($this->getDelivery(), $this->getPayment());

        // обсчёт на основе выбранных значений
        $this->calculate();

        // полный обсчёт списков доставок и оплат
        $this->calculateLists();
    }

    protected function receiptCreate(?CartDelivery $cartDelivery, ?CartPayment $cartPayment): Receipt
    {
        return $this->factoryReceipt->create(
            $this->getProductList(),
            $cartDelivery,
            $cartPayment,
            $this->getPromocode()
        );
    }

    protected function calculate(): void
    {
        $this->price = 0;
        $this->priceDiscounted = 0;

        if ($this->getProductList()) {
            $this->getProductList()->loadReceiptProductList($this->receipt->getProductList());

            $this->price += $this->getProductList()->getPrice();
            $this->priceDiscounted += $this->getProductList()->getPriceDiscountedOrPrice();
        }

        if ($this->getDelivery()) {
            $this->getDelivery()->loadReceiptDelivery($this->receipt->getDelivery());

            $this->price += $this->getDelivery()->getPrice();
            $this->priceDiscounted += $this->getDelivery()->getPriceDiscountedOrPrice();
        }

        if ($this->getPayment()) {
            $this->getPayment()->loadReceiptPayment($this->receipt->getPayment());

            $this->price += $this->getPayment()->getPrice();
            $this->priceDiscounted += $this->getPayment()->getPriceDiscountedOrPrice();
        }

        if ($this->priceDiscounted === $this->price) {
            $this->priceDiscounted = null;
        }

        if ($this->getPriceDiscountedOrPrice() === 0) {
            $this->getPaymentList()->clearItems();
        }
    }

    protected function calculateLists(): void
    {
        /** @var CartDelivery $cartDelivery */
        foreach ($this->getDeliveryList()->getItems() as $cartDelivery) {
            if ($cartDelivery->isSelected()) {
                continue; // уже обсчитывали
            }
            $cartDelivery->loadReceiptDelivery(
                $this->receiptCreate($cartDelivery, $this->getPayment())->getDelivery()
            );
        }

        /** @var CartPayment $cartPayment */
        foreach ($this->getPaymentList()->getItems() as $cartPayment) {
            if ($cartPayment->isSelected()) {
                continue; // уже обсчитывали
            }
            $cartPayment->loadReceiptPayment(
                $this->receiptCreate($this->getDelivery(), $cartPayment)->getPayment()
            );
        }

        // применился ли промокод
        if ($this->getPromocode()) {
            $this->getPromocode()->setSuccess(
                $this->getIsSuccess(
                    $this->getPromocode(),
                    $this->priceDiscounted,
                    $this->getDeliveryList(),
                )
            );
        }
    }

    /**
     * @param CartPromocode $cartPromocode
     * @param int|null $priceDiscounted
     * @param CartDeliveryList $cartDeliveryList
     * @return bool
     */
    protected function getIsSuccess(CartPromocode $cartPromocode, ?int $priceDiscounted, CartDeliveryList $cartDeliveryList): bool
    {
        if ($cartPromocode->isAlwaysAvailable()) {
            return true;
        }
        if ($priceDiscounted !== null) {
            return true;
        }
        if ($cartDeliveryList->hasDiscounted() === true) {
            return true;
        }
        if ($cartDeliveryList->hasItems() === false && $cartPromocode->isWithFreeDelivery()) {
            return true;
        }

        return false;
    }
}
