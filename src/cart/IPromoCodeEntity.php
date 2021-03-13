<?php
declare(strict_types=1);


namespace app\modules\cart\src\cart;


interface IPromoCodeEntity
{
    public function getId();
    public function getCode();
    public function isDiscountTypeDeliveryForAll();
    public function isDiscountTypeWithDeliveryFree();
}
