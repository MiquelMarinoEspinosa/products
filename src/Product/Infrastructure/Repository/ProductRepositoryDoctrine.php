<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Repository;

use Doctrine\ORM\EntityRepository;
use App\Product\Domain\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use App\Product\Domain\Entity\ProductCollection;
use App\Product\Domain\Repository\ProductCriteria;
use App\Product\Domain\Repository\ProductRepository;

final class ProductRepositoryDoctrine implements ProductRepository
{
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->repository = $this->entityManager->getRepository(Product::class);
    }

    public function findByCriteria(ProductCriteria $productCriteria): ProductCollection
    {
        $queryBuilder = $this->repository->createQueryBuilder('p');
        $products = $queryBuilder->getQuery()->execute();

        return new ProductCollection($products);
    }
}
