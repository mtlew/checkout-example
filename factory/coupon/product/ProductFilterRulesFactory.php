<?php
declare(strict_types=1);


namespace app\modules\cart\factory\coupon\product;


use app\models\entities\PromoCodeEntity;
use app\modules\cart\src\coupon\product\rule\Rule;
use app\modules\cart\src\coupon\product\rule\RuleCategories;
use app\modules\cart\src\coupon\product\rule\RuleProducts;
use app\modules\cart\src\coupon\product\rule\RulePromo;

class ProductFilterRulesFactory
{

    /**
     * @param string $discountRule
     * @param object $options
     * @return Rule[]
     */
    public function create(string $discountRule, object $options): array
    {
        $rules = [];

        switch ($discountRule) {

            case PromoCodeEntity::DISCOUNT_RULE_CATEGORY:
                $rules[] = new RuleCategories($options->categoryIds);
                break;

            case PromoCodeEntity::DISCOUNT_RULE_PRODUCT:
                $rules[] = new RuleProducts($options->productIds);
                break;
        }

        if ($options->except_discount_products) {
            $rules[] = new RulePromo();
        }

        return $rules;
    }
}
