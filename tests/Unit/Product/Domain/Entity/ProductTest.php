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
        $product = new Product(
            self::SKU,
            $this->faker->name(),
            self::CATEGORY_BOOTS,
            $this->faker->numberBetween()
        );

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
}