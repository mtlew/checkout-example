<?php
declare(strict_types=1);


namespace app\modules\cart\factory\coupon;


use app\models\entities\PromoCodeEntity;
use app\modules\cart\factory\coupon\conditions\ConditionsFactory;
use app\modules\cart\factory\coupon\product\ProductFilterFactory;

use app\modules\cart\src\coupon\{
    CouponDelivery,
    CouponDeliveryDiscount,
    CouponDeliveryMoney, CouponDiscount,
    CouponMoney,
    CouponMoneyDelivery,
};

class CouponFactory
{

    private $factoryProductFilter;
    private $factoryConditions;


    public function __construct(ProductFilterFactory $productFilterFactory, ConditionsFactory $conditionsFactory)
    {
        $this->factoryProductFilter = $productFilterFactory;
        $this->factoryConditions = $conditionsFactory;
    }

    /**
     * @param PromoCodeEntity $promoCodeEntity
     * @return CouponDelivery|CouponDeliveryDiscount|CouponDeliveryMoney|CouponDiscount|CouponMoney|CouponMoneyDelivery|null
     */
    public function create(PromoCodeEntity $promoCodeEntity)
    {
        $discountType = $promoCodeEntity->getDiscountType();
        $discountRule = $promoCodeEntity->getDiscountRule();

        $options = $promoCodeEntity->getDiscountRuleOptions();
        $options = (object)$options;

        $couponClass = $this->getCouponClass($discountType, $options);
        $couponValue = $this->getCouponValue($discountType, $options);

        return new $couponClass($couponValue,
            $this->factoryProductFilter->create($discountRule, $options),
            $this->factoryConditions->create($discountRule, $options)
        );
    }

    /**
     * @param string $discountType
     * @param object $options
     * @return string|null
     */
    private function getCouponClass(string $discountType, object $options): ?string
    {
        switch ($discountType) {

            case PromoCodeEntity::DISCOUNT_TYPE_CASH:
                if ($options->allowPaymentDelivery) {
                    return CouponMoneyDelivery::class;
                }
                return CouponMoney::class;

            case PromoCodeEntity::DISCOUNT_TYPE_PERCENT:
                return CouponDiscount::class;

            case PromoCodeEntity::DISCOUNT_TYPE_DELIVERY:
                return CouponDelivery::class;

            case PromoCodeEntity::DISCOUNT_TYPE_DELIVERY_CASH_DISCOUNT:
                return CouponDeliveryMoney::class;

            case PromoCodeEntity::DISCOUNT_TYPE_DELIVERY_PERCENT_DISCOUNT:
                return CouponDeliveryDiscount::class;

            default:
                return null;
        }
    }

    /**
     * @param string $discountType
     * @param object $options
     * @return int
     */
    private function getCouponValue(string $discountType, object $options): int
    {
        switch ($discountType) {
            case PromoCodeEntity::DISCOUNT_TYPE_CASH:
            case PromoCodeEntity::DISCOUNT_TYPE_DELIVERY_CASH_DISCOUNT:
                return (int)$options->discount_amount * 100;

            case PromoCodeEntity::DISCOUNT_TYPE_PERCENT:
            case PromoCodeEntity::DISCOUNT_TYPE_DELIVERY_PERCENT_DISCOUNT:
                return (int)$options->discount_percent;

            case PromoCodeEntity::DISCOUNT_TYPE_DELIVERY:
            default:
                return 0;
        }
    }
}
