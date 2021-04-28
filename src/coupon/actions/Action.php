<?php
declare(strict_types=1);


namespace app\modules\cart\src\coupon\actions;


use app\modules\cart\src\coupon\discount\Discount;
use app\modules\cart\src\receipt\_base\IDiscountable;

abstract class Action
{

    protected $discountType;


    public function __construct(Discount $discountType)
    {
        $this->discountType = $discountType;
    }

    abstract public function run(IDiscountable $receiptItem): void;
}
