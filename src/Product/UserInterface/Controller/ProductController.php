<?php

declare(strict_types=1);

namespace App\Product\UserInterface\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Product\Application\Query\FindProducts\FindProductsQuery;

final class ProductController
{
    public function __construct(private MessageBusInterface $bus)
    {
    }

    #[Route('/products', methods: ['GET'])]
    public function create(Request $request): JsonResponse
    {
        try {
            //$body = json_decode($request->getContent(), true);
            $query = new FindProductsQuery(
                null,
                null
            );
            $envelope = $this->bus->dispatch($query);
            $response = $envelope->last(HandledStamp::class);

            $products = [
                'products' => array_slice($response->getResult()->productResponses, 0, 5)
            ];

            return new JsonResponse($products, Response::HTTP_OK);
        } catch (\Exception $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
