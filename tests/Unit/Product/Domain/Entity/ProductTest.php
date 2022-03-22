<?php

declare(strict_types=1);

namespace App\Tests\Unit\Product\Domain\Entity;

use App\Product\Domain\Entity\Product;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

final class ProductTest extends TestCase
{
    private const SKU = '000001';
    private const CATEGORY_BOOTS = 'boots';
    private const CATEGORY_SANDALS = 'sandals';
    private const DISCOUNT_BOOTS = 0.3;
    private const SKU_0000003 = '0000003';
    private const DISCOUNT_SKU_0000003 = 0.15;

    private Generator $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
    }

    /**
     * @test
     */
    public function shouldReturnTheSku(): void
    {
        $product = $this->buildDefaultProduct();

        $this->assertSame(
            self::SKU,
            $product->sku()
        );
    }

    /**
     * @test
     */
    public function shouldReturnTheName(): void
    {
        $name = $this->faker->name();
        $product = new Product(
            self::SKU,
            $name,
            self::CATEGORY_BOOTS,
            $this->faker->numberBetween()
        );

        $this->assertSame(
            $name,
            $product->name()
        );
    }

    /**
     * @test
     */
    public function shouldReturnTheCategory(): void
    {
        $product = $this->buildDefaultProduct();

        $this->assertSame(
            self::CATEGORY_SANDALS,
            $product->category()
        );
    }

    /**
     * @test
     */
    public function shouldReturnThePrice(): void
    {
        $price = $this->faker->numberBetween();
        $product = new Product(
            self::SKU,
            $this->faker->name(),
            self::CATEGORY_BOOTS,
            $price
        );

        $this->assertSame(
            $price,
            $product->price()
        );
    }

    /**
     * @test
     */
    public function givenTheProductWithNoDiscountShouldReturnNoDiscount(): void
    {
        $product = $this->buildDefaultProduct();

        $this->assertNull(
            $product->discount()
        );
    }

    /**
     * @test
     */
    public function givenTheProductWithNoDiscountShouldReturnPriceWithDiscountEqualOriginalPrice(): void
    {
        $product = $this->buildDefaultProduct();

        $this->assertSame(
            $product->price(),
            $product->priceWithDiscount()
        );
    }

    /**
     * @test
     */
    public function givenAProductWithCategoryBootsShouldReturnThePercentDiscount(): void
    {
        $product = new Product(
            self::SKU,
            $this->faker->name(),
            self::CATEGORY_BOOTS,
            $this->faker->numberBetween()
        );

        $this->assertSame(
            self::DISCOUNT_BOOTS,
            $product->discount()
        );
    }

    /**
     * @test
     */
    public function givenAProductWithCategoryBootsShouldReturnAPriceWithThePercentDiscountApplied(): void
    {
        $price = $this->faker->numberBetween();
        $product = new Product(
            self::SKU,
            $this->faker->name(),
            self::CATEGORY_BOOTS,
            $price
        );

        $this->assertSame(
            (int) round($price * (1 - self::DISCOUNT_BOOTS)),
            $product->priceWithDiscount()
        );
    }

    /**
     * @test
     */
    public function givenAProductWithSku0000003ShouldReturnThePercentDiscount(): void
    {
        $product = new Product(
            self::SKU_0000003,
            $this->faker->name(),
            self::CATEGORY_SANDALS,
            $this->faker->numberBetween()
        );

        $this->assertSame(
            self::DISCOUNT_SKU_0000003,
            $product->discount()
        );
    }

    /**
     * @test
     */
    public function givenAProductWithSku0000003ShouldReturnAPriceWithThePercentDiscountApplied(): void
    {
        $price = $this->faker->numberBetween();
        $product = new Product(
            self::SKU_0000003,
            $this->faker->name(),
            self::CATEGORY_SANDALS,
            $price
        );

        $this->assertSame(
            (int) round($price * (1 - self::DISCOUNT_SKU_0000003)),
            $product->priceWithDiscount()
        );
    }

    /**
     * @test
     */
    public function givenABootsProductWithSku0000003ShouldReturnTheBiggestDiscount(): void
    {
        $product = new Product(
            self::SKU_0000003,
            $this->faker->name(),
            self::CATEGORY_BOOTS,
            $this->faker->numberBetween()
        );

        $this->assertSame(
            self::DISCOUNT_BOOTS,
            $product->discount()
        );
    }

    /**
     * @test
     */
    public function givenABootsProductWithSku0000003ShouldReturnAPriceWithTheCategoryBootsPercentDiscountApplied(): void
    {
        $price = $this->faker->numberBetween();
        $product = new Product(
            self::SKU_0000003,
            $this->faker->name(),
            self::CATEGORY_BOOTS,
            $price
        );

        $this->assertSame(
            (int) round($price * (1 - self::DISCOUNT_BOOTS)),
            $product->priceWithDiscount()
        );
    }

    private function buildDefaultProduct(): Product
    {
        return new Product(
            self::SKU,
            $this->faker->name(),
            self::CATEGORY_SANDALS,
            $this->faker->numberBetween()
        );
    }
}
