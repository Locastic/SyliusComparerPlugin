<?php

declare(strict_types=1);

namespace spec\Locastic\SyliusComparerPlugin\Factory;

use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Locastic\SyliusComparerPlugin\Entity\ComparerProductInterface;
use Locastic\SyliusComparerPlugin\Factory\ComparerProductFactory;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class ComparerProductFactorySpec extends ObjectBehavior
{
    function let(FactoryInterface $factory)
    {
        $this->beConstructedWith($factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ComparerProductFactory::class);
    }

    function it_should_implement_comparer_product_factory_interface()
    {
        $this->shouldHaveType(ComparerProductFactory::class);
    }

    function it_creates_comparer_product(FactoryInterface $factory, ComparerProductInterface $comparerProduct): void
    {
        $factory->createNew()->willReturn($comparerProduct);
        $this->createNew()->shouldReturn($comparerProduct);
    }

    function it_creates_comparer_product_for_comparer_and_product(
        FactoryInterface $factory,
        ComparerProductInterface $comparerProduct,
        ComparerInterface $comparer,
        ProductInterface $product
    ): void {
        $factory->createNew()->willReturn($comparerProduct);
        $comparerProduct->setComparer($comparer)->shouldBeCalled();
        $comparerProduct->setProduct($product)->shouldBeCalled();
        $this->createForComparerAndProduct($comparer, $product);
    }
}
