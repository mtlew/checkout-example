<?php
declare(strict_types=1);


namespace app\modules\cart\factory\receipt;


use app\modules\cart\src\cart\CartProductList;
use app\modules\cart\src\receipt\ReceiptProductList;

class ReceiptProductListFactory
{

    private $factory;


    public function __construct(ReceiptProductFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param CartProductList $cartProductList
     * @return ReceiptProductList
     */
    public function create(CartProductList $cartProductList): ReceiptProductList
    {
        $items = [];

        foreach ($cartProductList->getProducts() as $cartProduct) {
            $items = array_merge($items, $this->factory->create($cartProduct));
        }

        return new ReceiptProductList(...$items);
    }
}
