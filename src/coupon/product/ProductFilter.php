<?php
declare(strict_types=1);


namespace app\modules\cart\src\coupon\product;


use app\modules\cart\src\coupon\product\rule\Rule;
use app\modules\cart\src\receipt\ReceiptProduct;

class ProductFilter
{

    protected $rules;


    public function __construct(Rule ...$rules)
    {
        $this->rules = $rules;
    }

    public function filter(ReceiptProduct ...$items): array
    {
        foreach ($this->rules as $rule) {
            $items = $this->filterByRule($rule, ...$items);
        }

        return $items;
    }

    protected function filterByRule(Rule $rule, ReceiptProduct ...$items): array
    {
        $result = [];

        foreach ($items as $item) {
            if (!$rule->isFollowing($item)) {
                continue;
            }
            $item->setFiltered(true);

            $result[] = $item;
        }

        return $result;
    }
}
