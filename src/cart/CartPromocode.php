<?php
declare(strict_types=1);


namespace app\modules\cart\src\cart;


class CartPromocode
{

    protected $entity;
    protected $success;


    public function __construct(IPromoCodeEntity $promoCodeEntity)
    {
        $this->entity = $promoCodeEntity;
    }

    public function getId(): int
    {
        return (int)$this->entity->getId();
    }

    public function getCode(): string
    {
        return $this->entity->getCode();
    }

    public function getEntity(): IPromoCodeEntity
    {
        return $this->entity;
    }

    public function isAlwaysAvailable(): bool
    {
        return $this->entity->isDiscountTypeDeliveryForAll();
    }

    public function isWithFreeDelivery(): bool
    {
        return $this->entity->isDiscountTypeWithDeliveryFree();
    }

    public function getSuccess(): bool
    {
        return $this->success;
    }

    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }
}
