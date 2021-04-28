<?php
declare(strict_types=1);


namespace app\modules\cart\src\coupon\actions;


use app\modules\cart\src\receipt\_base\IDiscountable;

class ActionDiscountByType extends Action
{

    public function run(IDiscountable $receiptItem): void
    {
        $receiptItem->setPriceDiscounted(
            $this->discountType->process(
                $receiptItem->getPrice()
            )
        );
    }
}
