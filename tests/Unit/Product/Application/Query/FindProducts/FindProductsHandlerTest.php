<?php

declare(strict_types=1);

namespace App\Tests\Unit\Product\Application\Query\FindProducts;

use App\Product\Application\Exception\CannotFindProducts;
use App\Product\Application\Query\FindProducts\FindProductsHandler;
use App\Product\Application\Query\FindProducts\FindProductsQuery;
use App\Product\Domain\Entity\ProductCollection;
use App\Product\Domain\Repository\ProductCriteria;
use App\Product\Domain\Repository\ProductRepository;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class FindProductsHandlerTest extends TestCase
{
    private Generator $faker;
    private ProductRepository|MockObject $productRepository;
    private FindProductsHandler $handler;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
        $this->productRepository = $this->createMock(ProductRepository::class);
        $this->handler = new FindProductsHandler(
            $this->productRepository
        );
    }

    /**
     * @test
     */
    public function shouldThrownAnExceptionWhenProductRepositoryFails(): void
    {
        $this->expectException(CannotFindProducts::class);
        $category = null;
        $priceLessThan = null;
        $query = new FindProductsQuery($category, $priceLessThan);
        $criteria = new ProductCriteria(
            $query->category,
            $query->priceLessThan
        );
        $this->productRepository
            ->expects(self::once())
            ->method('findByCriteria')
            ->with($criteria)
            ->willThrowException(new \Exception());
        $this->handler->__invoke($query);
    }

    /**
     * @test
     */
    public function shouldReturnEmptyProductsResponse(): void
    {
        $category = null;
        $priceLessThan = null;
        $query = new FindProductsQuery($category, $priceLessThan);
        $criteria = new ProductCriteria(
            $query->category,
            $query->priceLessThan
        );
        $this->productRepository
            ->expects(self::once())
            ->method('findByCriteria')
            ->with($criteria)
            ->willReturn(new ProductCollection([]));
        $response = $this->handler->__invoke($query);
        $this->assertEmpty($response->productResponses);
    }
}
