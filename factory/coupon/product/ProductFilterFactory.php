<?php
declare(strict_types=1);


namespace app\modules\cart\factory\coupon\product;


use app\modules\cart\src\coupon\product\ProductFilter;

class ProductFilterFactory
{

    private $rulesFactory;


    public function __construct(ProductFilterRulesFactory $rulesFactory)
    {
        $this->rulesFactory = $rulesFactory;
    }

    public function create(string $discountRule, object $options): ?ProductFilter
    {
        $rules = $this->rulesFactory->create($discountRule, $options);

        if (empty($rules)) {
            return null;
        }

        return new ProductFilter(
            ...$this->rulesFactory->create($discountRule, $options)
        );
    }
}
