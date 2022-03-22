<?php

declare(strict_types=1);

namespace App\Product\Application\Query\FindProducts;

final class FindProductsQuery
{
    public function __construct(
        public readonly ?string $category,
        public readonly ?string $priceLessThan
    ) {
    }
}
