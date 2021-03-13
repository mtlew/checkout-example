<?php
declare(strict_types=1);


namespace app\modules\cart\src\cart;


use app\modules\cart\src\cart\_base\Discountable;
use app\modules\cart\src\receipt\ReceiptProductList;

class CartProductList extends Discountable
{

    protected $products;


    /**
     * @param CartProduct[] $cartProducts
     */
    public function __construct(array $cartProducts)
    {
        $this->products = $cartProducts;
        $this->price = $this->getListPriceSum();
    }

    /**
     * @return CartProduct[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * Наличие цифровых товаров
     * @return bool
     */
    public function hasDigital(): bool
    {
        foreach ($this->getProducts() as $cartProduct) {
            if ($cartProduct->isDigital()) {
                return true;
            }
        }

        return false;
    }

    public function loadReceiptProductList(ReceiptProductList $receiptProductList): void
    {
        $this->priceDiscounted = $receiptProductList->getPriceDiscountedOrNull();

        foreach ($this->getProducts() as $cartProduct) {
            $cartProduct->loadFromReceipt(
                $receiptProductList->getProductPriceDiscountedOrNull(
                    $cartProduct->getId()
                )
            );
        }
    }

    protected function getListPriceSum(): int
    {
        return $this->sum(function(CartProduct $cartProduct) {
            return $cartProduct->getPrice();
        });
    }

    protected function sum(callable $function): int
    {
        return array_sum(array_map($function, $this->getProducts()));
    }
}
