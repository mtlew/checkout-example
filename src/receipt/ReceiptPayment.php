<?php
declare(strict_types=1);


namespace app\modules\cart\src\receipt;


use app\modules\cart\src\receipt\_base\Discountable;

class ReceiptPayment extends Discountable
{

    protected $id;
    protected $name;
    protected $percentage;


    public function __construct(int $id, string $name, float $percentage)
    {
        $this->id = $id;
        $this->name = $name;
        $this->percentage = $percentage;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setPrice(int $value): void
    {
        $this->price = $this->calculate($value);
        $this->priceDiscounted = $this->price;
    }

    public function setPriceDiscounted(int $value): void
    {
        $this->priceDiscounted = $this->calculate($value);
    }

    /**
     * Нужно пробрасывать сверху, чтобы можно было реюзать, но пока нигде не потребовалось
     * @param int $value
     * @return int
     */
    protected function calculate(int $value): int
    {
        return (int)ceil($value * $this->percentage / 100);
    }
}
