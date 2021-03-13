<?php
declare(strict_types=1);


namespace app\modules\cart\src\cart;


use app\modules\cart\src\cart\_base\CartList;

class CartDeliveryList extends CartList
{

    public function __construct(bool $hasDigitalProduct, CartDelivery ...$items)
    {
        $this->hasDigitalProduct = $hasDigitalProduct;
        $this->items = $items;
    }

    public function hasDiscounted(): bool
    {
        foreach ($this->items as $item) {
            if ($item->getPriceDiscounted() !== null) {
                return true;
            }
        }

        return false;
    }
}
