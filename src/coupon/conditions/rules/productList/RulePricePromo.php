<?php
declare(strict_types=1);


namespace app\modules\cart\src\coupon\conditions\rules\productList;


use app\modules\cart\src\coupon\conditions\rules\Rule;
use app\modules\cart\src\receipt\ReceiptProductList;

class RulePricePromo implements Rule
{

    protected $price;


    public function __construct(int $price)
    {
        $this->price = $price;
    }

    public function isFollowing(ReceiptProductList $receiptProductList): bool
    {
        return $receiptProductList->getPriceExceptInPromo() > $this->price;
    }
}
