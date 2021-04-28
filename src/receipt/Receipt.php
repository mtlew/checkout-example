<?php
declare(strict_types=1);


namespace app\modules\cart\src\receipt;


use app\modules\cart\src\coupon\Coupon;
use app\modules\cart\src\receipt\_base\IDiscountable;

class Receipt
{

    protected $discounter;
    protected $productList;
    protected $delivery;
    protected $payment;
    protected $coupon;


    public function __construct(IDiscounter $discounter, ReceiptProductList $itemList, ?ReceiptDelivery $delivery, ?ReceiptPayment $payment, ?Coupon $coupon)
    {
        $this->discounter = $discounter;
        $this->productList = $itemList;
        $this->delivery = $delivery;
        $this->payment = $payment;
        $this->coupon = $coupon;

        $this->init();
    }

    public function getProductList(): ReceiptProductList
    {
        return $this->productList;
    }


    public function getDelivery(): ?ReceiptDelivery
    {
        return $this->delivery;
    }


    public function getPayment(): ?ReceiptPayment
    {
        return $this->payment;
    }


    public function getCoupon(): ?Coupon
    {
        return $this->coupon;
    }


    protected function init(): void
    {
        if ($this->getDelivery()) {
            $this->getDelivery()->setPrice($this->getProductList()->getProducts());
        }
        if ($this->getPayment()) {
            $this->getPayment()->setPrice($this->getPriceDiscounted(false));
        }
        $this->discounter->run($this);
    }


    /**
     * @return IDiscountable[]
     */
    protected function getDiscountableProperties(): array
    {
        return [
            $this->getProductList(),
            $this->getDelivery(),
            $this->getPayment(),
        ];
    }

    public function getPrice(): int
    {
        $result = 0;

        foreach ($this->getDiscountableProperties() as $discountable) {
            if ($discountable === null) {
                continue;
            }
            $result+= $discountable->getPrice();
        }

        return $result;
    }


    public function getPriceDiscounted(bool $includePayment = true): int
    {
        $result = 0;

        foreach ($this->getDiscountableProperties() as $discountable) {
            if ($discountable === null) {
                continue;
            }
            if ($includePayment === false && $discountable instanceof ReceiptPayment) {
                continue;
            }
            $result+= $discountable->getPriceDiscounted();
        }

        return $result;
    }
}
