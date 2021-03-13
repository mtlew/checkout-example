<?php
declare(strict_types=1);


namespace app\modules\cart\src\coupon\discount;


interface Discount
{
    public function __construct(int $value, bool $multiple);

    public function process(int $value): int;
}
