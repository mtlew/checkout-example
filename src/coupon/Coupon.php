<?php
declare(strict_types=1);


namespace app\modules\cart\src\coupon;


use app\modules\cart\src\coupon\actions\Action;
use app\modules\cart\src\coupon\actions\ActionDiscountByType;
use app\modules\cart\src\coupon\conditions\Conditions;
use app\modules\cart\src\coupon\discount\Discount;
use app\modules\cart\src\coupon\product\ProductFilter;

abstract class Coupon
{

    protected $discount;
    protected $productFilter;
    protected $conditions;

    protected $discountClass       = null;
    protected $actionProductClass  = ActionDiscountByType::class;
    protected $actionDeliveryClass = null;


    public function __construct(int $value, ?ProductFilter $productFilter, Conditions $conditions)
    {
        $this->init();

        $this->productFilter = $productFilter;
        $this->conditions = $conditions;

        $this->discount = $this->createDiscount($value);
    }

    public function getProductFilter(): ?ProductFilter
    {
        return $this->productFilter;
    }

    public function getConditions(): Conditions
    {
        return $this->conditions;
    }

    public function getProductDiscountAction(): Action
    {
        return $this->createDiscountAction($this->actionProductClass);
    }

    public function getDeliveryDiscountAction(): ?Action
    {
        return $this->createDiscountAction($this->actionDeliveryClass);
    }

    protected function createDiscount(int $value): Discount
    {
        return new $this->discountClass($value, !is_null($this->getProductFilter()));
    }

    protected function createDiscountAction(?string $class): ?Action
    {
        if ($class === null) {
            return null;
        }
        return new $class($this->discount);
    }

    abstract protected function init(): void;
}
