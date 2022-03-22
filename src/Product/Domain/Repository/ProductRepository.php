<?php

declare(strict_types=1);

namespace App\Product\Domain\Repository;

use Doctrine\Common\Collections\ArrayCollection;

interface ProductRepository
{
    public function findByCriteria(ProductCriteria $productCriteria): ArrayCollection;
}
