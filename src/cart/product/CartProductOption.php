<?php
declare(strict_types=1);


namespace app\modules\cart\src\cart\product;


class CartProductOption
{

    public $id;
    public $name;
    public $value;


    public function __construct(IProductOptionEntity $optionEntity)
    {
        $this->id = $optionEntity->getOption()->getId();
        $this->name = $optionEntity->getOption()->getName();
        $this->value = $optionEntity->getValue()->getValue();
    }
}
