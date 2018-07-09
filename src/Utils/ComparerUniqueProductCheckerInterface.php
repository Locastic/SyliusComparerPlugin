<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Utils;

use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Sylius\Component\Core\Model\ProductInterface;

interface ComparerUniqueProductCheckerInterface
{
    public static function isProductAlreadyInComparer(ComparerInterface $comparer, ProductInterface $product): bool;
}
