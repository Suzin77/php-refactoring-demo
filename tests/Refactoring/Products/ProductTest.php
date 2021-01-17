<?php

namespace Tests\Refactoring\Products;

use Brick\Math\BigDecimal;
use PHPUnit\Framework\TestCase;
use Refactoring\Products\Product;

class ProductTest extends TestCase
{
    /**
     * @test
     */
    public function canIncrementCounterIfPriceIsPositive(): void
    {
        //given
        $p = $this->productWithPriceAndCounter(BigDecimal::ten(), 10);

        //when
        $p->incrementCounter();

        //then
        $this->assertEquals(11, $p->getCounter());
    }

    /**
     * @test
     */
    public function canIncrementCounterIfPriceIsPositiveAndCounterIsZero(): void
    {
        //given
        $p = $this->productWithPriceAndCounter(BigDecimal::ten(), 0);

        //when
        $p->incrementCounter();

        //then
        $this->assertEquals(1, $p->getCounter());
    }

    /**
     * @test
     */
    public function canDecrementCounterIfPriceIsPositiveAndCounterIsOne(): void
    {
        //given
        $p = $this->productWithPriceAndCounter(BigDecimal::ten(), 1);

        //when
        $p->decrementCounter();

        //then
        $this->assertEquals(0, $p->getCounter());
    }

    /**
     * @test
     */
    public function exceptionThrownWhenDecrementZeroCounter(): void
    {
        $p = $this->productWithPriceAndCounter(BigDecimal::ten(), 0);

        $this->expectExceptionMessage("Negative counter");
        $p->decrementCounter();
    }

    /**
     * @test
     */
    public function cannotChangePriceIfCounterIsNotPositive(): void
    {
        //given
        $p = $this->productWithPriceAndCounter(BigDecimal::zero(), 0);

        //when
        $p->changePriceTo(BigDecimal::ten());

        //then
        $this->assertEquals(BigDecimal::zero(), $p->getPrice());
    }

    /**
     * @test
     */

    public function cannotChangePriceIfNewPriceIsNullAndCounterIsPositive(): void
    {
        //expect
        $this->expectException(\Exception::class);

        $p = $this->productWithPriceAndCounter(BigDecimal::zero(),10);

        $p->changePriceTo(null);
    }

    /**
     * @test
     */
    public function canChangePriceToNewPriceIfCounterIsPositive(): void
    {
        $p = $this->productWithPriceAndCounter(BigDecimal::ten(),10);

        $p->changePriceTo(BigDecimal::of(5));

        $this->assertEquals(BigDecimal::of(5),$p->getPrice());
    }

    /**
     * @test
     */
    public function canFormatDescription(): void
    {
        //expect
        $this->assertEquals("short *** long", $this->productWithDesc("short", "long")->formatDesc());
        $this->assertEquals("", $this->productWithDesc("short", "")->formatDesc());
        $this->assertEquals("", $this->productWithDesc("", "long2")->formatDesc());
    }

    /**
     * @test
     */
    public function canChangeCharInDescription(): void
    {
        //given
        $p = $this->productWithDesc("short", "long");

        //when
        $p->replaceCharFromDesc('s', 'z');

        //expect
        $this->assertEquals("zhort *** long", $p->formatDesc());
    }


    /**
     * @param BigDecimal $price
     * @param int $counter
     * @return Product
     */
    private function productWithPriceAndCounter(BigDecimal $price, int $counter): Product
    {
        return new Product($price, "desc", "longDesc", $counter);
    }

    /**
     * @param string $desc
     * @param string $longDesc
     * @return Product
     */
    private function productWithDesc(string $desc, string $longDesc): Product
    {
        return new Product(BigDecimal::ten(), $desc, $longDesc, 10);
    }


}