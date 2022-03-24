<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Repository;

use App\Product\Domain\Entity\Product;
use App\Product\Domain\Entity\ProductCollection;
use App\Product\Domain\Repository\ProductCriteria;
use App\Product\Domain\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

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
