<?php
declare(strict_types=1);


namespace app\modules\cart\src\cart;


use app\modules\cart\src\cart\_base\CartList;

class CartPaymentList extends CartList
{

    public function __construct(bool $hasDigitalProduct, CartPayment ...$items)
    {
        $this->hasDigitalProduct = $hasDigitalProduct;
        $this->items = $items;
    }
}
