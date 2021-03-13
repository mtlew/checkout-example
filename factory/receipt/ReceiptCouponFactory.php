<?php
declare(strict_types=1);


namespace app\modules\cart\factory\receipt;

use app\modules\cart\src\cart\CartPromocode;
use app\modules\cart\factory\coupon\CouponFactory;

class ReceiptCouponFactory
{

    private $factory;


    public function __construct(CouponFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param CartPromocode|null $cartPromocode
     * @return \app\modules\cart\src\coupon\CouponDelivery|\app\modules\cart\src\coupon\CouponDeliveryDiscount|\app\modules\cart\src\coupon\CouponDeliveryMoney|\app\modules\cart\src\coupon\CouponDiscount|\app\modules\cart\src\coupon\CouponMoney|\app\modules\cart\src\coupon\CouponMoneyDelivery|null
     */
    public function create(?CartPromocode $cartPromocode)
    {
        if ($cartPromocode === null) {
            return null;
        }

        return $this->factory->create($cartPromocode->getEntity());
    }
}
