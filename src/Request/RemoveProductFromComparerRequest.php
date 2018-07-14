<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Request;

use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;

final class RemoveProductFromComparerRequest implements ComparerRequestInterface
{
    /** @var string */
    private $productId;

    /** @var ComparerInterface */
    private $comparer;

    public function __construct(string $productId, ComparerInterface $comparer)
    {
        $this->productId = $productId;
        $this->comparer = $comparer;
    }

    public function getComparer(): ComparerInterface
    {
        return $this->comparer;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }
}
