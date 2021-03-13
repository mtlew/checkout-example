<?php
declare(strict_types=1);


namespace app\modules\cart\factory\cart;


use app\modules\cart\src\cart\CartDelivery;
use app\modules\delivery\method\entity\MethodEntity;
use app\modules\delivery\modules\_base\calculator\CalculatorInterface;
use app\modules\delivery\modules\_base\MethodFieldValidator;

class CartDeliveryFactory
{

    public function create(CalculatorInterface $calculator, MethodFieldValidator $validator, MethodEntity $entity): CartDelivery
    {
        return new CartDelivery(
            $calculator,
            $validator,
            $entity->getId(),
            $entity->getService()->getCode(),
            $entity->getName(),
            $entity->isDigital(),
            $entity->getFieldsVisible(),
        );
    }
}
