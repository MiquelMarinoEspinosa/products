<?php

declare(strict_types=1);

namespace App\Product\Application\Response;

final class ProductResponse
{
    public function __construct(
        public readonly string $sku,
        public readonly string $name,
        public readonly string $category,
        public readonly int $price,
        public readonly int $priceWithDiscount,
        public readonly ?float $discount
    ) {
    }
}
