<?php

declare(strict_types=1);

namespace App\Product\Application\Query\FindProducts;

final class FindProductsResponse
{
    /**
     * @param ProductResponse[] $productResponse
     */
    public function __construct(
        public readonly array $productResponses
    ) {
    }
}
