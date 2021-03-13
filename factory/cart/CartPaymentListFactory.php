<?php
declare(strict_types=1);


namespace app\modules\cart\factory\cart;


use app\models\entities\payment\PaymentEntity;
use app\models\services\front\PaymentService;
use app\modules\cart\src\cart\CartPaymentList;
use app\modules\delivery\method\MethodService;

class CartPaymentListFactory
{

    private $factoryPayment;
    private $serviceDelivery;
    private $servicePayment;


    public function __construct(
        CartPaymentFactory $factoryPayment,
        MethodService $serviceMethod,
        PaymentService $servicePayment
    )
    {
        $this->factoryPayment  = $factoryPayment;
        $this->serviceDelivery = $serviceMethod;
        $this->servicePayment  = $servicePayment;
    }

    /**
     * @param int|null $deliveryId
     * @param int $deliveryListCount
     * @param int|null $paymentId
     * @param bool $hasDigitalProduct
     * @return CartPaymentList
     */
    public function create(?int $deliveryId, int $deliveryListCount, ?int $paymentId, bool $hasDigitalProduct): CartPaymentList
    {
        $items = [];
        foreach ($this->getPaymentEntities($deliveryId, $deliveryListCount) as $entity) {
            $items[] = $this->factoryPayment->create($entity);
        }
        $cartPaymentList = new CartPaymentList($hasDigitalProduct, ...$items);
        $cartPaymentList->setItemSelected($paymentId);

        return $cartPaymentList;
    }

    /**
     * @param int|null $deliveryId
     * @param int $deliveryListCount
     * @return PaymentEntity[]
     */
    private function getPaymentEntities(?int $deliveryId, int $deliveryListCount): array
    {
        if ($deliveryId === null && $deliveryListCount > 0) {
            return [];
        }
        if ($deliveryId === null) {
            return $this->servicePayment->getList();
        }
        $methodEntity = $this->serviceDelivery->getById($deliveryId);

        if ($methodEntity === null) {
            return $this->servicePayment->getList();
        }

        return $this->servicePayment->getByDeliveryMethod($methodEntity);
    }
}
