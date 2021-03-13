<?php
declare(strict_types=1);


namespace app\modules\cart\factory\receipt;


use app\modules\cart\src\cart\CartPayment;
use app\modules\cart\src\receipt\ReceiptPayment;

class ReceiptPaymentFactory
{

    public function create(?CartPayment $cartPayment): ?ReceiptPayment
    {
        if ($cartPayment === null) {
            return null;
        }

        return new ReceiptPayment(
            $cartPayment->getId(),
            $cartPayment->getName(),
            $cartPayment->getPercentage()
        );
    }
}
