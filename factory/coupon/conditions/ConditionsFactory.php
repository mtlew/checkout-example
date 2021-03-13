<?php
declare(strict_types=1);


namespace app\modules\cart\factory\coupon\conditions;


use app\modules\cart\src\coupon\conditions\Conditions;

class ConditionsFactory
{

    private $factoryProductList;


    public function __construct(ConditionProductListFactory $productListFactory)
    {
        $this->factoryProductList = $productListFactory;
    }

    public function create(string $discountRule, object $options)
    {
        return new Conditions(
            $this->factoryProductList->create($discountRule, $options)
        );
    }
}
