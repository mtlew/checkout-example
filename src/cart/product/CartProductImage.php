<?php
declare(strict_types=1);


namespace app\modules\cart\src\cart\product;


class CartProductImage
{

    public $url;
    public $alt;


    public function __construct(string $url, string $alt)
    {
        $this->url = $url;
        $this->alt = $alt;
    }
}
