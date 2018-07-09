<?php

declare(strict_types=1);

namespace spec\Locastic\SyliusComparerPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Locastic\SyliusComparerPlugin\Entity\Comparer;
use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Locastic\SyliusComparerPlugin\Entity\ComparerProductInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ShopUserInterface;

final class ComparerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Comparer::class);
    }

    function it_should_implement_comparer_interface()
    {
        $this->shouldHaveType(ComparerInterface::class);
    }

    function it_should_have_default_ID_null(): void
    {
        $this->getID()->shouldBeNull();
    }

    function it_gets_products(ComparerProductInterface $comparerProduct, ProductInterface $product)
    {
        $comparerProduct->getProduct()->willReturn($product);
        $comparerProduct->setComparer($this)->shouldBeCalled();

        $this->addComparerProduct($comparerProduct);

        $this->getProducts()->shouldBeAnInstanceOf(Collection::class);
    }

    function it_should_check_has_comparerProducts(ComparerProductInterface $comparerProduct, ProductInterface $product)
    {
        $comparerProduct->getProduct()->willReturn($product);
        $comparerProduct->setComparer($this)->shouldBeCalled();

        $this->addComparerProduct($comparerProduct);

        $this->hasComparerProduct($comparerProduct)->shouldReturn(true);
    }

    function it_gets_comparerProduct(ComparerProductInterface $comparerProduct, ProductInterface $product)
    {
        $comparerProduct->getProduct()->willReturn($product);
        $comparerProduct->setComparer($this)->shouldBeCalled();

        $this->addComparerProduct($comparerProduct);

        $this->getComparerProduct($product)->shouldReturn($comparerProduct);
    }

    function it_gets_comparerProducts(ComparerProductInterface $comparerProduct, ProductInterface $product)
    {
        $comparerProduct->getProduct()->willReturn($product);
        $comparerProduct->setComparer($this)->shouldBeCalled();

        $this->addComparerProduct($comparerProduct);

        $this->getComparerProducts()->contains($comparerProduct);
    }

    function it_gets_number_of_products_in_comparer(ComparerProductInterface $comparerProduct, ProductInterface $product)
    {
        $comparerProduct->getProduct()->willReturn($product);
        $comparerProduct->setComparer($this)->shouldBeCalled();

        $this->addComparerProduct($comparerProduct);

        $this->getNumberOfProductsInComparer()->shouldReturn(1);
    }

    function it_adds_comparerProduct(ComparerProductInterface $comparerProduct, ProductInterface $product)
    {
        $comparerProduct->getProduct()->willReturn($product);
        $comparerProduct->setComparer($this)->shouldBeCalled();

        $this->hasComparerProduct($comparerProduct)->shouldReturn(false);

        $this->addComparerProduct($comparerProduct);

        $this->getComparerProducts()->contains($comparerProduct)->shouldReturn(true);
    }

    function it_gets_comparer_attributes(ProductInterface $product, ComparerProductInterface $comparerProduct)
    {
        $locale = 'locale';
        $defaultLocale = 'defaultLocale';

        $comparerProduct->getProduct()->willReturn($product);

        $this->getComparerAttributes($this->getProducts(), $locale, $defaultLocale)->shouldReturnAnInstanceOf(Collection::class);
    }

    function it_should_get_token()
    {
        $value = 'comparer_plugin_token'; //this serves as a token value because phpspec requires non-objects to be created manually
        $this->setToken($value);

        $this->getToken()->shouldReturn($value);
    }

    function it_should_set_shopUser(ShopUserInterface $shopUser)
    {
        $this->setShopUser($shopUser)->shouldReturn(null);
    }

    function it_should_get_shopUser(ShopUserInterface $shopUser)
    {
        $this->setShopUser($shopUser);

        $this->getShopUser()->shouldReturn($shopUser);
    }
}
