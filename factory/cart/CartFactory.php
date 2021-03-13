<?php
declare(strict_types=1);


namespace app\modules\cart\factory\cart;


use app\models\services\front\order\FormFieldsService;
use app\modules\cart\src\cart\Cart;
use app\modules\cart\factory\receipt\ReceiptFactory;

class CartFactory
{

    private $factoryReceipt;
    private $factoryProductList;
    private $factoryDeliveryList;
    private $factoryPaymentList;
    private $factoryPromocode;
    private $serviceOrderFields;


    public function __construct(
        ReceiptFactory $factoryReceipt,
        CartProductListFactory $factoryProductList,
        CartDeliveryListFactory $factoryDeliveryList,
        CartPaymentListFactory $factoryPaymentList,
        CartPromocodeFactory $factoryPromocode,
        FormFieldsService $serviceOrderFields
    )
    {
        $this->factoryReceipt      = $factoryReceipt;
        $this->factoryProductList  = $factoryProductList;
        $this->factoryDeliveryList = $factoryDeliveryList;
        $this->factoryPaymentList  = $factoryPaymentList;
        $this->factoryPromocode    = $factoryPromocode;
        $this->serviceOrderFields  = $serviceOrderFields;
    }

    public function create(array $cartItems, ?int $deliveryId, array $deliveryFields, ?int $paymentId, ?string $promocode): Cart
    {
        $cartProductList = $this->factoryProductList->create($cartItems);
        $cartProductListHasDigital = $cartProductList->hasDigital();

        $cartDeliveryList = $this->factoryDeliveryList->create($deliveryFields, $deliveryId, $cartProductListHasDigital);
        $cartDeliveryListCount = $cartDeliveryList->getItemsCount();

        $cartPaymentList = $this->factoryPaymentList->create(
            $cartDeliveryList->getItemSelectedId(),
            $cartDeliveryListCount,
            $paymentId,
            $cartProductListHasDigital,
        );

        return new Cart(
            $this->factoryReceipt,
            $cartProductList,
            $cartDeliveryList,
            $cartPaymentList,
            $this->factoryPromocode->create($promocode),
            $this->serviceOrderFields->getList(),
        );
    }
}
