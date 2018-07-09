<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Factory;

use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Locastic\SyliusComparerPlugin\Entity\ComparerProductInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

interface ComparerProductFactoryInterface extends FactoryInterface
{
    public function createForComparerAndProduct(ComparerInterface $comparer, ProductInterface $product): ComparerProductInterface;
}
