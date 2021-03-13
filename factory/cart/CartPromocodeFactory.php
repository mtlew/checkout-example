<?php
declare(strict_types=1);


namespace app\modules\cart\factory\cart;


use app\models\services\front\PromoCodeService;
use app\modules\cart\src\cart\CartPromocode;

class CartPromocodeFactory
{

    private $service;


    public function __construct(PromoCodeService $service)
    {
        $this->service = $service;
    }

    /**
     * @param string|null $promocode
     * @return CartPromocode|null
     */
    public function create(?string $promocode): ?CartPromocode
    {
        if ($promocode === null) {
            return null;
        }
        $promocode = trim($promocode);

        if (strlen($promocode) === 0) {
            return null;
        }
        $promoCodeEntity = $this->service->getByCode($promocode);

        if ($promoCodeEntity === null) {
            return null;
        }
        if ($promoCodeEntity->isActiveInCart() === false) {
            return null;
        }

        return new CartPromocode($promoCodeEntity);
    }
}
