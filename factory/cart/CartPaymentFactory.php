<?php
declare(strict_types=1);


namespace app\modules\cart\factory\cart;


use app\models\entities\payment\PaymentEntity;
use app\modules\cart\src\cart\CartPayment;

class CartPaymentFactory
{

    public function create(PaymentEntity $paymentMethodEntity): CartPayment
    {
        return new CartPayment(
            $paymentMethodEntity->getId(),
            $paymentMethodEntity->getTitle(),
            $paymentMethodEntity->getDescription(),
            (float)$paymentMethodEntity->getMarkupPercentage(),
            $paymentMethodEntity->isDigital(),
        );
    }
}
