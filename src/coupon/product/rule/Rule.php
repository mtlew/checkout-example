<?php
declare(strict_types=1);


namespace app\modules\cart\src\coupon\product\rule;


use app\modules\cart\src\receipt\ReceiptProduct;

interface Rule
{
    public function isFollowing(ReceiptProduct $receiptProduct): bool;
}
