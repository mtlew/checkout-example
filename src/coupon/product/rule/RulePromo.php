<?php
declare(strict_types=1);


namespace app\modules\cart\src\coupon\product\rule;


use app\modules\cart\src\receipt\ReceiptProduct;

class RulePromo implements Rule
{

    public function isFollowing(ReceiptProduct $receiptProduct): bool
    {
        if (!$receiptProduct->isInPromo()) {
            return true;
        }

        return false;
    }
}
