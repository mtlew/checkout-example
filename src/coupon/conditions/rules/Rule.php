<?php
declare(strict_types=1);


namespace app\modules\cart\src\coupon\conditions\rules;


use app\modules\cart\src\receipt\ReceiptProductList;

interface Rule
{
    public function isFollowing(ReceiptProductList $receiptProductList): bool;
}
