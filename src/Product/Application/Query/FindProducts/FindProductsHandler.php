<?php

declare(strict_types=1);

namespace App\Product\Application\Query\FindProducts;

use App\Product\Application\Exception\CannotFindProducts;
use App\Product\Application\Response\ProductResponse;
use App\Product\Domain\Repository\ProductCriteria;
use App\Product\Domain\Repository\ProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
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
            $productCollection = $this->productRepository->findByCriteria($criteria);

            $productResponses = array_map(
                fn ($product) => new ProductResponse(
                    $product->sku(),
                    $product->name(),
                    $product->category(),
                    $product->price(),
                    $product->priceWithDiscount(),
                    $product->discount()
                ),
                $productCollection->products()
            );

            return new FindProductsResponse($productResponses);
        } catch (\Exception $exception) {
            throw new CannotFindProducts($exception->getMessage());
        }
    }
}
