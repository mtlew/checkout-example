<?php
declare(strict_types=1);


namespace app\modules\cart\src\coupon;


use app\modules\cart\src\coupon\actions\ActionMakeFree;
use app\modules\cart\src\coupon\discount\DiscountAbsolute;

class CouponDelivery extends Coupon
{

    protected function init(): void
    {
        $this->discountClass = DiscountAbsolute::class;
        $this->actionDeliveryClass = ActionMakeFree::class;
    }
}
