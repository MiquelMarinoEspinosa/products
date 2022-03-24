<?php

declare(strict_types=1);

namespace App\Product\UserInterface\Controller;

use App\Product\Application\Query\FindProducts\FindProductsQuery;
use App\Product\Application\Query\FindProducts\FindProductsResponse;
use App\Product\Application\Response\ProductResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

final class ProductController
{
    private const MAX_RESULTS = 5;
    private const CURRENCY_EUR = 'EUR';
    private const PERCENT = '%';

    public function __construct(private MessageBusInterface $bus)
    {
    }

    #[Route('/products', methods: ['GET'])]
    public function create(Request $request): JsonResponse
    {
        try {
            $priceLessThan = $request->query->get('priceLessThan');
            $query = new FindProductsQuery(
                $request->query->get('category'),
                null === $priceLessThan ? $priceLessThan : (int) $priceLessThan
            );
            $envelope = $this->bus->dispatch($query);
            $response = $envelope->last(HandledStamp::class);

            return new JsonResponse(['products' => $this->formatResponse($response->getResult())], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'error' => [
                    'message' => $exception->getMessage(),
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function formatResponse(FindProductsResponse $findProductResponse): array
    {
        return array_map(
            fn (ProductResponse $productResponse) => [
                'sku' => $productResponse->sku,
                'name' => $productResponse->name,
                'category' => $productResponse->category,
                'price' => [
                    'original' => $productResponse->price,
                    'final' => $productResponse->priceWithDiscount,
                    'discount_percentatge' => (null === $productResponse->discount) ? $productResponse->discount : (100 * $productResponse->discount) . self::PERCENT,
                    'currency' => self::CURRENCY_EUR,
                ],
            ],
            array_slice($findProductResponse->productResponses, 0, self::MAX_RESULTS)
        );
    }
}
