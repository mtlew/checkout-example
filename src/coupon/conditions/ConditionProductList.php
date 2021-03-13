<?php
declare(strict_types=1);


namespace app\modules\cart\src\coupon\conditions;


use app\modules\cart\src\coupon\conditions\rules\Rule;
use app\modules\cart\src\receipt\ReceiptProductList;

class ConditionProductList
{

    protected $rules;


    public function __construct(Rule ...$rules)
    {
        $this->rules = $rules;
    }

    public function check(ReceiptProductList $receiptProductList): bool
    {
        foreach ($this->rules as $rule) {
            if (!$rule->isFollowing($receiptProductList)) {
                return false;
            }
        }
        return true;
    }
}
