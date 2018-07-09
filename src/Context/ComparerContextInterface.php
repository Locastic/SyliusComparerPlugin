<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Context;

use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Symfony\Component\HttpFoundation\Request;

interface ComparerContextInterface
{
    public function getComparer(Request $request): ?ComparerInterface;
}
