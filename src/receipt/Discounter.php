<?php
declare(strict_types=1);


namespace app\modules\cart\src\receipt;


use app\modules\cart\src\coupon\Coupon;

class Discounter implements IDiscounter
{


    public function run(Receipt $receipt): bool
    {
        $coupon = $receipt->getCoupon();

        if ($coupon === null) {
            return false;
        }
        if ($coupon->getConditions()->isFollowing($receipt) === false) {
            return false;
        }

        return $this->discount($coupon, $receipt);
    }


    protected function discount(Coupon $coupon, Receipt $receipt): bool
    {
        $productListDiscounted = $this->discountProductList($coupon, $receipt->getProductList());

        $this->recalculateDelivery($receipt);

        $deliveryDiscounted = $this->discountDelivery($coupon, $receipt->getDelivery(), $productListDiscounted);

        $this->recalculatePayment($receipt);

        return in_array(true, [$productListDiscounted, $deliveryDiscounted], true);
    }


    protected function discountProductList(Coupon $coupon, ReceiptProductList $receiptProductList): bool
    {
        $items = $receiptProductList->getProductsByFilter($coupon->getProductFilter());

        if (empty($items)) {
            return false;
        }
        $discountAction = $coupon->getProductDiscountAction();

        if ($discountAction === null) {
            return false;
        }

        foreach ($items as $item) {
            $discountAction->run($item);
        }

        return true;
    }


    protected function discountDelivery(Coupon $coupon, ?ReceiptDelivery $receiptDelivery, bool $productListDiscounted): bool
    {
        if ($productListDiscounted === false) {
            return false;
        }
        if ($receiptDelivery === null) {
            return false;
        }

        // новая особенность: стоимость доставки может быть null (нельзя посчитать, не хватает данных)
        if ($receiptDelivery->getPrice() === null) {
            return false;
        }

        $discountAction = $coupon->getDeliveryDiscountAction();

        if ($discountAction === null) {
            return false;
        }
        $discountAction->run($receiptDelivery);

        return true;
    }


    protected function recalculateDelivery(Receipt $receipt): void
    {
        if ($receipt->getDelivery() === null) {
            return;
        }
        $receipt->getDelivery()->setPrice($receipt->getProductList()->getProducts());
    }


    protected function recalculatePayment(Receipt $receipt): void
    {
        if ($receipt->getPayment() === null) {
            return;
        }
        $receipt->getPayment()->setPriceDiscounted($receipt->getPriceDiscounted(false));
    }
}
