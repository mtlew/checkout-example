<?php
declare(strict_types=1);


namespace app\modules\cart\src\receipt;


use app\modules\cart\src\cart\IDeliveryCalculator;
use app\modules\cart\src\receipt\_base\Discountable;

class ReceiptDelivery extends Discountable
{

    protected $id;
    protected $name;
    protected $dayMin;
    protected $dayMax;

    protected $calculator;


    public function __construct(int $id, string $name, IDeliveryCalculator $calculator)
    {
        $this->id = $id;
        $this->name = $name;
        $this->calculator = $calculator;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDayMin()
    {
        return $this->dayMin;
    }

    public function getDayMax()
    {
        return $this->dayMax;
    }

    public function setPrice(array $products): void
    {
        $this->calculator->calculate(...$products);

        $this->price  = $this->calculator->getPrice();
        $this->dayMin = $this->calculator->getDeliveryPeriodMin();
        $this->dayMax = $this->calculator->getDeliveryPeriodMax();

        $this->priceDiscounted = $this->price;
    }
}
