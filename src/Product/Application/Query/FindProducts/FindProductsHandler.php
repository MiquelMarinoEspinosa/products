<?php

declare(strict_types=1);

namespace App\Product\Application\Query\FindProducts;

use App\Product\Application\Exception\CannotFindProducts;
use App\Product\Domain\Repository\ProductCriteria;
use App\Product\Domain\Repository\ProductRepository;

final class FindProductsHandler
{
    private const ERROR_MESSAGE = 'Something went wrong';

    public function __construct(
        private ProductRepository $productRepository
    ) {
    }

    public function __invoke(FindProductsQuery $query): FindProductsResponse
    {
        try {
            $criteria = new ProductCriteria(
                $query->category,
                $query->priceLessThan
            );
            $this->productRepository->findByCriteria($criteria);
        } catch (\Exception $exception) {
            throw new CannotFindProducts(self::ERROR_MESSAGE);
        }
    }
}
