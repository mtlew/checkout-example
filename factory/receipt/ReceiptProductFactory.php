<?php
declare(strict_types=1);


namespace app\modules\cart\factory\receipt;


use app\modules\cart\src\cart\CartProduct;
use app\modules\cart\src\receipt\ReceiptProduct;

class ReceiptProductFactory
{

    public function create(CartProduct $cartProduct): array
    {
        $items = [];

        for ($i = 0; $i < $cartProduct->getQuantity(); $i++) {
            $items[] = new ReceiptProduct(
                $cartProduct->getId(),
                $cartProduct->getName(),
                $cartProduct->getCategoryIDs(),
                $cartProduct->getProductId(),
                $cartProduct->getPaymentSubjectId(),
                $cartProduct->isInPromo(),
                $cartProduct->getPriceOne()
            );
        }

        return $items;
    }
}
