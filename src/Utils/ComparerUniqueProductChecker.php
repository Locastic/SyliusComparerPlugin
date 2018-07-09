<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Utils;

use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Sylius\Component\Core\Model\ProductInterface;

class ComparerUniqueProductChecker implements ComparerUniqueProductCheckerInterface
{
    public static function isProductAlreadyInComparer(ComparerInterface $comparer, ProductInterface $product): bool
    {
        return $comparer->hasProduct($product);
    }
}
