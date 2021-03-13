<?php
declare(strict_types=1);


namespace app\modules\cart\src\receipt;


interface IProduct
{
    public function getPrice(): ?int;
    public function getPriceDiscounted(): ?int;
    public function getCategoryIDs(): array;
}
