<?php
declare(strict_types=1);


namespace app\modules\cart\src\receipt;


class ReceiptProductMin
{

    protected $id;
    protected $name;
    protected $price_discounted;
    protected $payment_subject_id;
    protected $quantity;


    public function __construct(int $id, string $name, int $priceDiscounted, int $paymentSubjectId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price_discounted = $priceDiscounted;
        $this->payment_subject_id = $paymentSubjectId;
        $this->quantity = 1;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPriceDiscounted(): int
    {
        return $this->price_discounted;
    }

    public function getPaymentSubjectId(): int
    {
        return $this->payment_subject_id;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function increaseQuantity(): void
    {
        $this->quantity++;
    }
}
