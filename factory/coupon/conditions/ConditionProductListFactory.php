<?php
declare(strict_types=1);


namespace app\modules\cart\factory\coupon\conditions;


use app\modules\cart\src\coupon\conditions\ConditionProductList;

class ConditionProductListFactory
{

    private $rulesFactory;


    public function __construct(ConditionProductListRulesFactory $rulesFactory)
    {
        $this->rulesFactory = $rulesFactory;
    }

    public function create(string $discountRule, object $options)
    {
        return new ConditionProductList(
            ...$this->rulesFactory->create($discountRule, $options)
        );
    }
}
