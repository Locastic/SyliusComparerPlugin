<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Utils;

use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;

final class ComparerCapacityChecker implements ComparerCapacityCheckerInterface
{
    /** @var int */
    private $comparerItemLimit;

    public function __construct(int $comparerItemLimit)
    {
        $this->comparerItemLimit = $comparerItemLimit;
    }

    public function isComparerFilled(ComparerInterface $comparer): bool
    {
        return $comparer->getNumberOfProductsInComparer() >= $this->comparerItemLimit;
    }

    public function isComparerEmpty(ComparerInterface $comparer): bool
    {
        return $comparer->getNumberOfProductsInComparer() == 0;
    }
}
