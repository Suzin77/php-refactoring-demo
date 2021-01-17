<?php

namespace Refactoring\Products;

use Brick\Math\BigDecimal;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Product
{
    /**
     * @var UuidInterface
     */
    private $serialNumber;

    /**
     * @var BigDecimal
     */
    private $price;

    /**
     * @var string
     */
    private $desc;

    /**
     * @var string
     */
    private $longDesc;

    /**
     * @var int
     */
    private $counter;

    /**
     * Product constructor.
     * @param BigDecimal|null $price
     * @param string|null $desc
     * @param string|null $longDesc
     * @param int|null $counter
     */
    public function __construct(?BigDecimal $price, ?string $desc, ?string $longDesc, ?int $counter)
    {
        $this->serialNumber = Uuid::uuid4();
        $this->price = $price;
        $this->desc = $desc;
        $this->longDesc = $longDesc;
        $this->counter = $counter;
    }

    /**
     * @return UuidInterface
     */
    public function getSerialNumber(): UuidInterface
    {
        return $this->serialNumber;
    }

    /**
     * @return BigDecimal
     */
    public function getPrice(): BigDecimal
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getDesc(): string
    {
        return $this->desc;
    }

    /**
     * @return string
     */
    public function getLongDesc(): string
    {
        return $this->longDesc;
    }

    /**
     * @return int
     */
    public function getCounter(): int
    {
        return $this->counter;
    }

    public function setPrice(BigDecimal $price): void
    {
        $this->price = $price;
    }

    /**
     * @param $longDesc
     * @return void
     */
    public function setLongDesc(?string $longDesc): void
    {
        $this->longDesc = $longDesc;
    }

    /**
     * @param string|null $desc
     * @return void
     */
    public function setDesc(?string $desc): void
    {
        $this->desc = $desc;
    }

    /**
     * @throws \Exception
     */
    public function decrementCounter(): void
    {
        ProductValidator::canDecrementCounter($this);
        $this->counter--;
    }

    /**
     * @throws \Exception
     */
    public function incrementCounter(): void
    {
        ProductValidator::canIncrementCounter($this);
        $this->counter++;
    }

    /**
     * @param BigDecimal|null $newPrice
     * @throws \Exception
     */
    public function changePriceTo(?BigDecimal $newPrice): void
    {
        ProductEditor::changePriceTo($this, $newPrice);
    }

    /**
     * @param string|null $charToReplace
     * @param string|null $replaceWith
     * @throws \Exception
     */
    public function replaceCharFromDesc(?string $charToReplace, ?string $replaceWith): void
    {
       ProductEditor::replaceCharFromDesc($charToReplace, $replaceWith, $this);
    }

    /**
     * @return string
     */
    public function formatDesc(): string
    {
        return ProductEditor::formatDesc($this);
    }


}





















