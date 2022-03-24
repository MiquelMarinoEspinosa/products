<?php

declare(strict_types=1);

namespace App\Tests\Unit\Product\Domain\Repository;

use App\Product\Domain\Repository\ProductCriteria;
use PHPUnit\Framework\TestCase;

final class ProductTest extends TestCase
{
    private const CATEGORY_BOOTS = 'boots';
    private const PRICE_LESS_THAN = 123456;

    /**
     * @test
     */
    public function shouldReturnANullCategory(): void
    {
        $criteria = new ProductCriteria(null, null);

        $this->assertNull($criteria->category());
    }

    /**
     * @test
     */
    public function shouldReturnANullPriceLessThan(): void
    {
        $criteria = new ProductCriteria(null, null);

        $this->assertNull($criteria->priceLessThan());
    }

    /**
     * @test
     */
    public function shouldReturnTheCategory(): void
    {
        $criteria = new ProductCriteria(self::CATEGORY_BOOTS, null);

        $this->assertSame(self::CATEGORY_BOOTS, $criteria->category());
    }

    /**
     * @test
     */
    public function shouldReturnThePriceLessThan(): void
    {
        $criteria = new ProductCriteria(self::CATEGORY_BOOTS, self::PRICE_LESS_THAN);

        $this->assertSame(self::PRICE_LESS_THAN, $criteria->priceLessThan());
    }
}
