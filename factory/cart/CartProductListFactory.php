<?php
declare(strict_types=1);


namespace app\modules\cart\factory\cart;


use app\models\entities\CartItemEntity;
use app\modules\cart\src\cart\CartProductList;

class CartProductListFactory
{

    private $factoryProduct;


    public function __construct(CartProductFactory $factory)
    {
        $this->factoryProduct = $factory;
    }

    /**
     * @param CartItemEntity[] $cartItems
     * @return CartProductList
     */
    public function create(array $cartItems): CartProductList
    {
        $items = [];
        foreach ($cartItems as $cartItem) {
            $items[] = $this->factoryProduct->create($cartItem);
        }

        return new CartProductList($items);
    }
}
