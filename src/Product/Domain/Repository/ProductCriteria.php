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

    public function category(): ?string
    {
        return $this->category;
    }

    public function priceLessThan(): ?int
    {
        return $this->priceLessThan;
    }
}
