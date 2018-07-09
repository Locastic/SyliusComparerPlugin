<?php


declare(strict_types=1);

namespace spec\Locastic\SyliusComparerPlugin\Entity;

use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Locastic\SyliusComparerPlugin\Entity\ComparerProduct;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ProductInterface;

final class ComparerProductSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ComparerProduct::class);
    }

    function it_sets_a_product(ProductInterface $product)
    {
        $this->setProduct($product)->shouldBeNull();
    }

    function it_gets_a_product(ProductInterface $product)
    {
        $this->setProduct($product);

        $this->getProduct()->shouldBeAnInstanceOf(ProductInterface::class);
    }

    function it_sets_a_comparer(ComparerInterface $comparer): void
    {
        $this->setComparer($comparer)->shouldBeNull();
    }

    function it_gets_a_comparer(ComparerInterface $comparer)
    {
        $this->setComparer($comparer);

        $this->getComparer()->shouldBeAnInstanceOf(ComparerInterface::class);
    }
}
