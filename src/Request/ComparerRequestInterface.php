<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Request;

use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;

interface ComparerRequestInterface
{
    public function getComparer(): ?ComparerInterface;

    public function getProductId(): ?string;
}
