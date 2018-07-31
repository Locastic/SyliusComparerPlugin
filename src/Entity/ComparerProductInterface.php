<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Entity;

use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface ComparerProductInterface extends ResourceInterface
{
    public function getProduct(): ?ProductInterface;

    public function setProduct(ProductInterface $product): void;

    public function getComparer(): ComparerInterface;

    public function setComparer(ComparerInterface $comparer): void;
}
