<?php
declare(strict_types=1);


namespace app\modules\cart\factory\cart;


use app\modules\cart\src\cart\CartDeliveryList;
use app\modules\delivery\method\MethodService;

class CartDeliveryListFactory
{

    private $factoryDeliveryCalculator;
    private $factoryDelivery;

    private $service;


    public function __construct(CartDeliveryFactory $factoryDelivery, CartDeliveryCalculatorFactory $factoryDeliveryCalculator, MethodService $service)
    {
        $this->factoryDelivery = $factoryDelivery;
        $this->factoryDeliveryCalculator = $factoryDeliveryCalculator;

        $this->service = $service;
    }

    /**
     * @param array $deliveryFields
     * @param int|null $deliveryId
     * @param bool $hasDigitalProduct
     * @return CartDeliveryList
     */
    public function create(array $deliveryFields, ?int $deliveryId, bool $hasDigitalProduct): CartDeliveryList
    {
        $entities = $this->service->getListVisible();

        $items = [];
        foreach ($entities as $entity) {
            $this->factoryDeliveryCalculator->createCalculatorValidator($entity->getService()->getCode(), $entity->getId(), $deliveryFields);

            $items[] = $this->factoryDelivery->create(
                $this->factoryDeliveryCalculator->getCalculator(),
                $this->factoryDeliveryCalculator->getValidator(),
                $entity,
            );
        }
        $cartDeliveryList = new CartDeliveryList($hasDigitalProduct, ...$items);
        $cartDeliveryList->setItemSelected($deliveryId);

        return $cartDeliveryList;
    }
}
