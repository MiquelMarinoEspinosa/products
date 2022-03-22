<?php

declare(strict_types=1);

namespace App\Product\Domain\Repository;

use App\Product\Domain\Entity\ProductCollection;

interface ProductRepository
{
    public function findByCriteria(ProductCriteria $productCriteria): ProductCollection;
}
