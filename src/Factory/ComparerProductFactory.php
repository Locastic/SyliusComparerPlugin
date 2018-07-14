<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Factory;

use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Locastic\SyliusComparerPlugin\Entity\ComparerProductInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

class ComparerProductFactory implements ComparerProductFactoryInterface
{
    /** @var FactoryInterface */
    private $comparerProductFactory;

    public function __construct(FactoryInterface $comparerProductFactory)
    {
        $this->comparerProductFactory = $comparerProductFactory;
    }

    public function createNew(): ComparerProductInterface
    {
        return  $this->comparerProductFactory->createNew();
    }

    public function createForComparerAndProduct(ComparerInterface $comparer, ProductInterface $product): ComparerProductInterface
    {
        $comparerProduct = $this->createNew();

        $comparerProduct->setComparer($comparer);
        $comparerProduct->setProduct($product);

        return $comparerProduct;
    }
}
