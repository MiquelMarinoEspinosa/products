<?php

declare(strict_types=1);

namespace App\Product\Domain\Repository;

final class ProductCriteria
{
    public function __construct(
        private ?string $category,
        private ?int $priceLessThan
    ) {
    }
}
