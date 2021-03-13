<?php
declare(strict_types=1);


namespace app\modules\cart\src\cart;


class CartDeliveryFieldList
{

    protected $items;


    public function __construct(IDeliveryFieldEntity ...$methodFieldEntities)
    {
        $this->items = $methodFieldEntities;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getItemByCode(string $code): ?IDeliveryFieldEntity
    {
        foreach ($this->getItems() as $item) {
            if ($code === $item->getCode()) {
                return $item;
            }
        }

        return null;
    }

    public function getItemValueByCode(string $code): ?string
    {
        $item = $this->getItemByCode($code);

        if ($item === null) {
            return null;
        }

        return $item->getValue();
    }
}
