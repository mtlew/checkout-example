<?php
declare(strict_types=1);


namespace app\modules\cart\src\cart\_base;


abstract class Discountable
{

    protected $price;
    protected $priceDiscounted;


    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function getPriceDiscounted(): ?int
    {
        return $this->priceDiscounted;
    }

    public function getPriceDiscountedOrPrice(): ?int
    {
        if ($this->getPriceDiscounted() === null) {
            return $this->getPrice();
        }
        return $this->getPriceDiscounted();
    }

    public function getDiscount(): ?int
    {
        return $this->getPrice() - $this->getPriceDiscountedOrPrice();
    }
}
