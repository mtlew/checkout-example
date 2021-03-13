<?php
declare(strict_types=1);


namespace app\modules\cart\src\coupon\discount;


class DiscountPercentage implements Discount
{

    protected $percentage;
    protected $multiple;


    public function __construct(int $percentage, bool $multiple)
    {
        $this->percentage = $percentage;
        $this->multiple   = $multiple; // здесь он ни на что не влияет
    }

    public function process(int $value): int
    {
        $result = (int)ceil($value - (($value * $this->percentage) / 100));
        $result = $result < 0 ? 0 : $result;

        return $result;
    }
}
