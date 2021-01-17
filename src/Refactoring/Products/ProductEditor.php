<?php

namespace Refactoring\Products;

use Brick\Math\BigDecimal;

class ProductEditor
{
    /**
     * @param Product $product
     * @param BigDecimal|null $newPrice
     * @throws \Exception
     */
    public static function changePriceTo(Product $product,?BigDecimal $newPrice): void
    {
       ProductValidator::canChangePriceTo($product, $newPrice)
           ? $product->setPrice($newPrice)
           : null;
    }

    /**
     * @param Product $product
     * @return string
     */
    static public function formatDesc(Product $product): string
    {
        return ProductValidator::isDescriptionNull($product)
            ?  ""
            : $product->getDesc(). " *** " . $product->getLongDesc();
    }

    /**
     * @param string|null $charToReplace
     * @param string|null $replaceWith
     * @param Product $product
     * @return void
     * @throws \Exception
     */
    static public function replaceCharFromDesc(?string $charToReplace, ?string $replaceWith,Product $product)
    {
        if (ProductValidator::isDescriptionNull($product)) {
            throw new \Exception("null or empty desc");
        }

        $newLongDesc = str_replace($charToReplace, $replaceWith, $product->getLongDesc());
        $product->setLongDesc($newLongDesc);

        $newDesc = str_replace($charToReplace, $replaceWith, $product->getDesc());
        $product->setDesc($newDesc);
    }

}