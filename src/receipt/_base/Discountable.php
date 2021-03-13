<?php
declare(strict_types=1);


namespace app\modules\cart\src\receipt\_base;


abstract class Discountable implements DiscountableInterface
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

    public function setPriceDiscounted(int $value): void
    {
        $this->priceDiscounted = $value;
    }

    public function getPriceDiscountedOrNull(): ?int
    {
        $result = $this->getPriceDiscounted();

        if ($result === $this->getPrice()) {
            return null;
        }

        return $result;
    }
}
