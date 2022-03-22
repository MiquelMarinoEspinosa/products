<?php

declare(strict_types=1);

namespace App\Product\Domain\Entity;

final class Product
{
    private const CATEGORY_BOOTS = 'boots';
    private const CATEGORY_BOOTS_DISCOUNT = 0.3;
    private const SKU_0000003 = '0000003';
    private const DISCOUNT_SKU_0000003 = 0.15;

    public function __construct(
        private string $sku,
        private string $name,
        private string $category,
        private int $price
    ) {
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function category(): string
    {
        return $this->category;
    }

    public function price(): int
    {
        return $this->price;
    }

    public function discount(): ?float
    {
        $discount = null;
        if (self::CATEGORY_BOOTS === $this->category) {
            $discount = self::CATEGORY_BOOTS_DISCOUNT;
        }

        if (self::SKU_0000003 === $this->sku && $discount < self::DISCOUNT_SKU_0000003) {
            $discount = self::DISCOUNT_SKU_0000003;
        }

        return $discount;
    }

    public function priceWithDiscount(): int
    {
        return (int) round($this->price * (1 - $this->discount()));
    }
}
