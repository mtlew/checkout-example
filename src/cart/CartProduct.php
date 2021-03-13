<?php
declare(strict_types=1);


namespace app\modules\cart\src\cart;


use app\modules\cart\src\cart\_base\Discountable;
use app\modules\cart\src\cart\product\CartProductImage;

class CartProduct extends Discountable
{

    protected $id;
    protected $name;
    protected $url;
    protected $isDigital;
    protected $vendorCode;
    protected $priceOne;
    protected $inPromo;
    protected $quantity;
    protected $inStock;
    protected $unlimited;
    protected $categoryIDs;
    protected $productId;
    protected $paymentSubjectId;
    protected $image;
    protected $optionList;


    public function __construct(
        int $id,
        string $name,
        string $url,
        bool $isDigital,
        string $vendorCode,
        int $price,
        bool $inPromo,
        int $quantity,
        int $inStock,
        bool $unlimited,
        array $categoryIDs,
        int $productId,
        int $paymentSubjectId,
        ?CartProductImage $cartProductImage,
        array $cartProductOptionList
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->url = $url;
        $this->isDigital = $isDigital;
        $this->vendorCode = $vendorCode;
        $this->priceOne = $price;
        $this->inPromo = $inPromo;
        $this->quantity = $quantity;
        $this->inStock = $inStock;
        $this->unlimited = $unlimited;
        $this->categoryIDs = $categoryIDs;
        $this->productId = $productId;
        $this->paymentSubjectId = $paymentSubjectId;
        $this->image = $cartProductImage;
        $this->optionList = $cartProductOptionList;

        $this->price = $this->priceOne * $this->quantity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function isDigital(): bool
    {
        return $this->isDigital;
    }

    public function getVendorCode(): string
    {
        return $this->vendorCode;
    }

    public function getPriceOne(): int
    {
        return $this->priceOne;
    }

    public function isInPromo(): bool
    {
        return $this->inPromo;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getInStock(): int
    {
        return $this->inStock;
    }

    public function getUnlimited(): bool
    {
        return $this->unlimited;
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

    public function getImage(): ?CartProductImage
    {
        return $this->image;
    }

    public function getOptionList(): array
    {
        return $this->optionList;
    }

    public function loadFromReceipt(?int $value): void
    {
        $this->priceDiscounted = $value;
    }
}
