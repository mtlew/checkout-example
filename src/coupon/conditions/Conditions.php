<?php
declare(strict_types=1);


namespace app\modules\cart\src\coupon\conditions;


use app\modules\cart\src\receipt\Receipt;

class Conditions
{

    protected $conditionProductList;


    public function __construct(ConditionProductList $conditionProductList)
    {
        $this->conditionProductList = $conditionProductList;
    }

    public function isFollowing(Receipt $receipt): bool
    {
        return $this->conditionProductList->check($receipt->getProductList());
    }
}
