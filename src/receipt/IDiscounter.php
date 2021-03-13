<?php
declare(strict_types=1);


namespace app\modules\cart\src\receipt;


interface IDiscounter
{
    public function run(Receipt $receipt): bool;
}
