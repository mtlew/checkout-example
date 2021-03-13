<?php
declare(strict_types=1);


namespace app\modules\cart\src\cart;


interface IDeliveryCalculator
{
    public function calculate(... $products);
    public function getPrice();
    public function getDeliveryPeriodMin();
    public function getDeliveryPeriodMax();
}
