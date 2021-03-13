<?php
declare(strict_types=1);


namespace app\modules\cart\src\cart;


use app\modules\cart\src\cart\_base\CartListItem;
use app\modules\cart\src\cart\_base\Discountable;
use app\modules\cart\src\receipt\ReceiptDelivery;

class CartDelivery extends Discountable
{
    use CartListItem;


    protected $calculator;
    protected $validator;

    protected $type;
    protected $name;
    protected $fields;
    protected $dayMin;
    protected $dayMax;


    public function __construct(
        IDeliveryCalculator $calculator,
        IDeliveryFieldValidator $validator,
        int $id,
        string $type,
        string $name,
        bool $isDigital,
        array $fields
    ) {
        $this->calculator = $calculator;
        $this->validator = $validator;

        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->isDigital = $isDigital;
        $this->fields = $fields;
    }

    public function getCalculator(): IDeliveryCalculator
    {
        return $this->calculator;
    }

    public function getValidator(): IDeliveryFieldValidator
    {
        return $this->validator;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function getDayMin()
    {
        return $this->dayMin;
    }

    public function getDayMax()
    {
        return $this->dayMax;
    }

    public function loadReceiptDelivery(ReceiptDelivery $receiptDelivery): void
    {
        $this->price           = $receiptDelivery->getPrice();
        $this->priceDiscounted = $receiptDelivery->getPriceDiscountedOrNull();
        $this->dayMin          = $receiptDelivery->getDayMin();
        $this->dayMax          = $receiptDelivery->getDayMax();
    }
}
