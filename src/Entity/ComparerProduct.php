<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Entity;

use Sylius\Component\Core\Model\ProductInterface;

class ComparerProduct implements ComparerProductInterface
{
    /** @var int */
    private $id;

    /** @var ComparerInterface */
    private $comparer;

    /** @var ProductInterface */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setComparer(ComparerInterface $comparer): void
    {
        $this->comparer = $comparer;
    }

    public function getComparer(): ComparerInterface
    {
        return $this->comparer;
    }

    public function setProduct(ProductInterface $product): void
    {
        $this->product = $product;
    }

    public function getProduct(): ?ProductInterface
    {
        return $this->product;
    }
}
