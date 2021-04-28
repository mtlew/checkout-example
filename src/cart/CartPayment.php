<?php
declare(strict_types=1);


namespace app\modules\cart\src\cart;


use app\modules\cart\src\cart\_base\CartListItem;
use app\modules\cart\src\cart\_base\Discountable;
use app\modules\cart\src\receipt\_base\IDiscountable as DiscountableReceipt;

class CartPayment extends Discountable
{

    use CartListItem;


    protected $name;
    protected $description;
    protected $percentage;


    public function __construct(int $id, string $name, ?string $description, float $percentage, bool $isDigital)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->percentage = $percentage;
        $this->isDigital = $isDigital;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPercentage(): float
    {
        return $this->percentage;
    }

    public function loadReceiptPayment(DiscountableReceipt $discountable): void
    {
        $this->price = $discountable->getPriceDiscounted();
    }

    public function getPriceDiscountedOrPrice(): int
    {
        return $this->price;
    }
}
