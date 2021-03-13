<?php
declare(strict_types=1);


namespace app\modules\cart\src\cart\_base;


use app\modules\cart\src\cart\CartDelivery;
use app\modules\cart\src\cart\CartPayment;

abstract class CartList
{

    protected $hasDigitalProduct;
    protected $items;


    /**
     * @return CartDelivery[]|CartPayment[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return bool
     */
    public function hasItems(): bool
    {
        return !empty($this->items);
    }

    /**
     * @return int
     */
    public function getItemsCount(): int
    {
        return count($this->getItems());
    }

    /**
     * @return CartDelivery[]|CartPayment[]
     */
    public function getItemsAvailable(): array
    {
        if ($this->hasDigitalProduct === false) {
            return $this->getItems();
        }

        return $this->getItemsDigital();
    }

    /**
     * @return int
     */
    public function getItemsAvailableCount(): int
    {
        return count($this->getItemsAvailable());
    }


    public function clearItems(): void
    {
        $this->items = [];
    }

    /**
     * @return CartDelivery|CartPayment|null
     */
    public function getItemSelected(): ?object
    {
        foreach ($this->getItems() as $item) {
            if ($item->isSelected()) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @return int|null
     */
    public function getItemSelectedId(): ?int
    {
        $item = $this->getItemSelected();

        if ($item === null) {
            return null;
        }

        return $item->getId();
    }

    /**
     * @param int|null $id
     * @return bool
     */
    public function setItemSelected(?int $id): bool
    {
        if ($id === null) {
            return $this->setItemAvailableSelectedFirst();
        }

        if ($this->setItemAvailableSelectedById($id)) {
            return true;
        }

        return $this->setItemAvailableSelectedFirst();
    }


    ####################################################################################################################


    protected function getItemsDigital(): array
    {
        $result = [];

        foreach ($this->getItems() as $item) {
            if ($item->isDigital()) {
                $result[] = $item;
            }
        }

        return $result;
    }

    /**
     * Пометить как selected элемент с нужным id
     * @param int $id
     * @return bool
     */
    protected function setItemAvailableSelectedById(int $id): bool
    {
        $this->setItemsUnselected();

        foreach ($this->getItemsAvailable() as $item) {
            if ($item->getId() === $id) {
                $item->setSelected(true);
                return true;
            }
        }

        return false;
    }

    /**
     * Пометить selected для первого элемента
     * @return bool
     */
    protected function setItemAvailableSelectedFirst(): bool
    {
        $item = $this->getItemAvailableFirst();

        if ($item === null) {
            return false;
        }

        return $this->setItemAvailableSelectedById($item->getId());
    }

    /**
     * @return CartDelivery|CartPayment|null
     */
    protected function getItemAvailableFirst(): ?object
    {
        if ($this->getItemsAvailableCount() === 0) {
            return null;
        }

        return array_values($this->getItemsAvailable())[0];
    }

    /**
     * Снять selected со всех элементов
     */
    protected function setItemsUnselected(): void
    {
        foreach ($this->getItems() as $item) {
            $item->setSelected(false);
        }
    }
}
