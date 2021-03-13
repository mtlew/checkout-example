<?php
declare(strict_types=1);


namespace app\modules\cart\factory\receipt;


use app\modules\cart\src\cart\CartDelivery;
use app\modules\cart\src\receipt\ReceiptDelivery;

class ReceiptDeliveryFactory
{

    public function create(?CartDelivery $cartDelivery): ?ReceiptDelivery
    {
        if ($cartDelivery === null) {
            return null;
        }

        return new ReceiptDelivery(
            $cartDelivery->getId(),
            $cartDelivery->getName(),
            $cartDelivery->getCalculator()
        );
    }
}
