<?php
declare(strict_types=1);


namespace app\modules\cart\factory\coupon\conditions;


use app\models\entities\PromoCodeEntity;
use app\modules\cart\src\coupon\conditions\rules\productList\RulePricePromo;
use app\modules\cart\src\coupon\conditions\rules\IRule;
use app\modules\cart\src\coupon\conditions\rules\productList\RulePrice;

class ConditionProductListRulesFactory
{

    /**
     * @param string $discountRule
     * @param object $options
     * @return IRule[]
     */
    public function create(string $discountRule, object $options): array
    {
        $rules = [];

        switch ($discountRule) {

            case PromoCodeEntity::DISCOUNT_RULE_AMOUNT:
                $price = (int)$options->amount_more_then * 100;

                if ($options->without_discount_products) {
                    $rules[] = new RulePricePromo($price);
                } else {
                    $rules[] = new RulePrice($price);
                }
                break;
        }

        return $rules;
    }
}
