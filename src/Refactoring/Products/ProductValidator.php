<?php

namespace Refactoring\Products;

use Brick\Math\BigDecimal;

class ProductValidator
{
    /**
     * @param Product $product
     * @return bool
     */
    public static function isDescriptionNull(Product $product): bool
    {
        return empty($product->getLongDesc()) || empty($product->getDesc());
    }

    /**
     * @param Product $product
     * @return bool
     * @throws \Exception
     */
    public static function validateCounterOperation(Product $product): bool
    {
        if (!self::isPriceValid($product->getPrice())){
            throw new \Exception("Invalid price");
        }

        if ($product->getCounter() === null) {
            throw new \Exception("null counter");
        }

        return true;
    }

    /**
     * @param Product $product
     * @return bool
     * @throws \Exception
     */
    public static function canIncrementCounter(Product $product): bool
    {
        self::validateCounterOperation($product);

        if ($product->getCounter() + 1 < 0){
            throw new \Exception("Negative counter");
        }

        return true;
    }

    /**
     * @param Product $product
     * @return bool
     * @throws \Exception
     */
    public static function canDecrementCounter(Product $product)
    {
        self::validateCounterOperation($product);

        if ($product->getCounter() - 1 < 0){
            throw new \Exception("Negative counter");
        }

        return true;
    }

    /**
     * @param Product $product
     * @param BigDecimal|null $newPrice
     * @return bool
     * @throws \Exception
     */
    public static function canChangePriceTo(Product $product, ?BigDecimal $newPrice): bool
    {
        if ($product->getCounter() === null) {
            throw new \Exception("null counter");
        }

        if ($newPrice === null) {
            throw new \Exception("new price null");
        }

        return $product->getCounter()> 0;
    }

    /**
     * @param BigDecimal|null $price
     * @return bool
     */
    protected static function isPriceValid(?BigDecimal $price): bool
    {
        return $price != null && $price->getSign() > 0;
    }
}