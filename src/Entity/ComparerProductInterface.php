<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Duje
 * Date: 28-May-18
 * Time: 4:22 PM
 */

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
