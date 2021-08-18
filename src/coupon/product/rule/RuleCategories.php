<?php
declare(strict_types=1);


namespace app\modules\cart\src\coupon\product\rule;


use app\modules\cart\src\receipt\ReceiptProduct;

class RuleCategories implements IRule
{

    protected $IDs;


    public function __construct(array $IDs)
    {
        $this->IDs = $IDs;
    }

    public function isFollowing(ReceiptProduct $receiptProduct): bool
    {
        if (array_intersect($this->IDs, $receiptProduct->getCategoryIDs())) {
            return true;
        }

        return false;
    }
}
