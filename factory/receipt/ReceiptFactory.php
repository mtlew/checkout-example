<?php
declare(strict_types=1);


namespace app\modules\cart\factory\receipt;


use app\modules\cart\src\cart\CartDelivery;
use app\modules\cart\src\cart\CartPayment;
use app\modules\cart\src\cart\CartProductList;
use app\modules\cart\src\cart\CartPromocode;
use app\modules\cart\src\receipt\Discounter;
use app\modules\cart\src\receipt\Receipt;

class ReceiptFactory
{

    private $discounter;
    private $factoryProductList;
    private $factoryDelivery;
    private $factoryPayment;
    private $factoryCoupon;


    public function __construct(
        Discounter $discounter,
        ReceiptProductListFactory $factoryProductList,
        ReceiptDeliveryFactory $factoryDelivery,
        ReceiptPaymentFactory $factoryPayment,
        ReceiptCouponFactory $factoryCoupon
    )
    {
        $this->discounter = $discounter;
        $this->factoryProductList = $factoryProductList;
        $this->factoryDelivery = $factoryDelivery;
        $this->factoryPayment = $factoryPayment;
        $this->factoryCoupon = $factoryCoupon;
    }

    public function create(CartProductList $productList, ?CartDelivery $delivery, ?CartPayment $payment, ?CartPromocode $promocode): Receipt
    {
        return new Receipt(
            $this->discounter,
            $this->factoryProductList->create($productList),
            $this->factoryDelivery->create($delivery),
            $this->factoryPayment->create($payment),
            $this->factoryCoupon->create($promocode)
        );
    }
}
