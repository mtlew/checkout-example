<?php
declare(strict_types=1);


namespace app\modules\cart\src\receipt;


use app\modules\cart\src\receipt\_base\Discountable;

class ReceiptProduct extends Discountable implements IProduct
{

    protected $id;
    protected $name;
    protected $categoryIDs;
    protected $productId;
    protected $paymentSubjectId;
    protected $inPromo;

    protected $filtered = false;


    public function __construct(int $id, string $name, array $categoryIDs, int $productId, int $paymentSubjectId, bool $inPromo, int $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->categoryIDs = $categoryIDs;
        $this->productId = $productId;
        $this->paymentSubjectId = $paymentSubjectId;
        $this->inPromo = $inPromo;

        $this->price = $price;
        $this->priceDiscounted = $this->price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategoryIDs(): array
    {
        return $this->categoryIDs;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getPaymentSubjectId(): int
    {
        return $this->paymentSubjectId;
    }

    public function isInPromo(): bool
    {
        return $this->inPromo;
    }

    public function isFiltered(): bool
    {
        return $this->filtered;
    }

    public function setFiltered(bool $filtered): void
    {
        $this->filtered = $filtered;
    }
}
