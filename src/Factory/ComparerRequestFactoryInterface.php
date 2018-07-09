<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Factory;

use Locastic\SyliusComparerPlugin\Request\ComparerRequestInterface;
use Symfony\Component\HttpFoundation\Request;

interface ComparerRequestFactoryInterface
{
    public function create(Request $request): ComparerRequestInterface;
}
