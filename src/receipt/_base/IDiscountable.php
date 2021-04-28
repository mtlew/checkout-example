<?php
declare(strict_types=1);


namespace app\modules\cart\src\receipt\_base;


interface IDiscountable
{

    public function getPrice(): ?int;

    public function getPriceDiscounted(): ?int;

    public function getPriceDiscountedOrNull(): ?int;

    public function setPriceDiscounted(int $value): void;
}
