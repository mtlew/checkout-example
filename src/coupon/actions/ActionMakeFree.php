<?php
declare(strict_types=1);


namespace app\modules\cart\src\coupon\actions;


use app\modules\cart\src\receipt\_base\DiscountableInterface;

class ActionMakeFree extends Action
{

    public function run(DiscountableInterface $receiptItem): void
    {
        $receiptItem->setPriceDiscounted(0);
    }
}
