<?php
declare(strict_types=1);


namespace app\modules\cart\src\coupon;


use app\modules\cart\src\coupon\discount\DiscountAbsolute;

class CouponMoney extends Coupon
{

    protected function init(): void
    {
        $this->discountClass = DiscountAbsolute::class;
    }
}
