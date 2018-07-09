<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Utils;

use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;

interface ComparerCapacityCheckerInterface
{
    public function isComparerFilled(ComparerInterface $comparer): bool;

    public function isComparerEmpty(ComparerInterface $comparer): bool;
}
