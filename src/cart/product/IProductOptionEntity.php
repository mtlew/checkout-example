<?php
declare(strict_types=1);


namespace app\modules\cart\src\cart\product;


interface IProductOptionEntity
{
    public function getOption();
    public function getValue();
}
