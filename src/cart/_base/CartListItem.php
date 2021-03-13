<?php
declare(strict_types=1);


namespace app\modules\cart\src\cart\_base;


trait CartListItem
{

    protected $id;
    protected $isDigital;
    protected $selected = false;


    public function getId(): int
    {
        return $this->id;
    }

    public function isDigital(): bool
    {
        return $this->isDigital;
    }

    public function isSelected(): bool
    {
        return $this->selected;
    }

    public function setSelected(bool $selected): void
    {
        $this->selected = $selected;
    }
}
