<?php
declare(strict_types=1);


namespace app\modules\cart\src\coupon\discount;


class DiscountAbsolute implements IDiscount
{

    protected $value;

    protected $balance;
    protected $multiple;


    public function __construct(int $value, bool $multiple)
    {
        $this->value = $value;

        $this->balance = $value;
        $this->multiple = $multiple;
    }

    public function process(int $value): int
    {
        if ($value === 0 || $this->balance === 0) {
            return $value;
        }
        $result = $value - $this->balance;
        $result = $result < 0 ? 0 : $result;

        $this->reduceBalance($value, $result);

        return $result;
    }

    protected function reduceBalance(int $value, int $result): void
    {
        if ($this->multiple === true) {
            return;
        }
        $this->balance = $this->balance - ($value - $result);
        $this->balance = $this->balance < 0 ? 0 : $this->balance;
    }
}
