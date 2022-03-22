<?php

declare(strict_types=1);

namespace App\Product\Domain\Entity;

final class ProductCollection
{
    /**
     * @param Product[] $products
     */
    public function __construct(
        private array $products
    ) {
    }

    /**
     * @return Product[]
     */
    public function products(): array
    {
        return $this->products;
    }
}
