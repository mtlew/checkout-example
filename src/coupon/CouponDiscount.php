<?php
declare(strict_types=1);


namespace app\modules\cart\src\coupon;


use app\modules\cart\src\coupon\discount\DiscountPercentage;

class CouponDiscount extends Coupon
{

    protected function init(): void
    {
        $this->discountClass = DiscountPercentage::class;
    }
}
