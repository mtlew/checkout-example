<?php
declare(strict_types=1);


namespace app\modules\cart\src\coupon\product\rule;


use app\modules\cart\src\receipt\ReceiptProduct;

class RuleProducts implements IRule
{

    protected $IDs;


    public function __construct(array $IDs)
    {
        $this->IDs = $IDs;
    }

    public function isFollowing(ReceiptProduct $receiptProduct): bool
    {
        if (in_array($receiptProduct->getProductId(), $this->IDs)) {
            return true;
        }

        return false;
    }
}
