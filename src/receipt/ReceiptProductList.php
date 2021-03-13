<?php
declare(strict_types=1);


namespace app\modules\cart\src\receipt;


use app\modules\cart\src\coupon\product\ProductFilter;
use app\modules\cart\src\receipt\_base\Discountable;

class ReceiptProductList extends Discountable
{

    protected $products;


    /**
     * @param ReceiptProduct ...$products
     */
    public function __construct(ReceiptProduct ...$products)
    {
        $this->products = $products;
    }

    /**
     * @return ReceiptProduct[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @return ReceiptProductMin[]
     */
    public function getProductsMin(): array
    {
        /** @var ReceiptProductMin[] $result */
        $result = [];

        foreach ($this->getProducts() as $receiptProduct) {

            if (count($result)) {
                $resultLast = $result[array_key_last($result)];

                if ($resultLast->getId() == $receiptProduct->getId() && $resultLast->getPriceDiscounted() == $receiptProduct->getPriceDiscounted()) {
                    $resultLast->increaseQuantity();
                    continue;
                }
            }

            $result[] = new ReceiptProductMin(
                $receiptProduct->getId(),
                $receiptProduct->getName(),
                $receiptProduct->getPriceDiscounted(),
                $receiptProduct->getPaymentSubjectId(),
            );
        }

        return $result;
    }

    /**
     * @param int $id
     * @return ReceiptProduct[]
     */
    public function getProductsById(int $id): array
    {
        $result = [];

        foreach ($this->getProducts() as $receiptProduct) {
            if ($receiptProduct->getId() === $id) {
                $result[] = $receiptProduct;
            }
        }

        return $result;
    }

    /**
     * @param ProductFilter|null $productFilter
     * @return ReceiptProduct[]
     */
    public function getProductsByFilter(?ProductFilter $productFilter): array
    {
        if ($productFilter === null) {
            return $this->getProducts();
        }
        return $productFilter->filter(...$this->getProducts());
    }


    public function getPrice(): int
    {
        return $this->sum(function(ReceiptProduct $receiptProduct) {
            return $receiptProduct->getPrice();
        }, $this->getProducts());
    }


    public function getPriceExceptInPromo(): int
    {
        return $this->sum(function(ReceiptProduct $receiptProduct) {
            if ($receiptProduct->isInPromo()) {
                return 0;
            }
            return $receiptProduct->getPrice();
        }, $this->getProducts());
    }


    public function getPriceDiscounted(): int
    {
        return $this->sum(function(ReceiptProduct $receiptProduct) {
            return $receiptProduct->getPriceDiscounted();
        }, $this->getProducts());
    }


    public function getProductPriceDiscountedOrNull(int $cartProductId): ?int
    {
        if ($this->getProductsById($cartProductId)[0]->isFiltered() === false) {
            return null;
        }
        $result = $this->getProductPriceDiscounted($cartProductId);

        if ($result === $this->getProductPrice($cartProductId)) {
            return null;
        }

        return $result;
    }


    protected function getProductPrice(int $cartProductId): int
    {
        return $this->sum(function(ReceiptProduct $receiptProduct) {
            return $receiptProduct->getPrice();
        }, $this->getProductsById($cartProductId));
    }


    protected function getProductPriceDiscounted(int $cartProductId): int
    {
        return $this->sum(function(ReceiptProduct $receiptProduct) {
            return $receiptProduct->getPriceDiscounted();
        }, $this->getProductsById($cartProductId));
    }


    protected function sum(callable $function, array $receiptProducts): int
    {
        return array_sum(array_map($function, $receiptProducts));
    }
}
