<?php

declare(strict_types=1);

namespace spec\Locastic\SyliusComparerPlugin\Factory;

use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Locastic\SyliusComparerPlugin\Factory\ComparerFactory;
use Locastic\SyliusComparerPlugin\Factory\ComparerFactoryInterface;
use Locastic\SyliusComparerPlugin\Utils\ComparerTokenInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class ComparerFactorySpec extends ObjectBehavior
{
    public function let(FactoryInterface $factory, ComparerTokenInterface $comparerToken): void
    {
        $this->beConstructedWith($factory, $comparerToken);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ComparerFactory::class);
    }

    function it_implements_comparer_factory_interface(): void
    {
        $this->shouldHaveType(ComparerFactoryInterface::class);
    }

    public function it_creates_new_comparer(FactoryInterface $factory, ComparerInterface $comparer, ComparerTokenInterface $comparerToken): void
    {
        $factory->createNew()->willReturn($comparer);
        $comparerToken->provide()->willReturn('1');
        $comparer->setToken('1')->shouldBeCalled();
        $this->createNew()->shouldReturn($comparer);
    }

    function it_creates_comparer_for_user(FactoryInterface $factory, ComparerInterface $comparer, ShopUserInterface $shopUser, ComparerTokenInterface $comparerToken): void
    {
        $factory->createNew()->willReturn($comparer);
        $comparerToken->provide()->willReturn('1');
        $comparer->setToken('1')->shouldBeCalled();

        $comparer->setShopUser($shopUser)->shouldBeCalled();
        $this->createForShopUser($shopUser)->shouldReturn($comparer);
    }
}
