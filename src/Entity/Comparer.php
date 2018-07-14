<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ShopUserInterface;

class Comparer implements ComparerInterface
{
    /** @var int */
    private $id;

    /** @var ComparerProductInterface[] */
    private $comparerProducts;

    /** @var ShopUserInterface */
    private $shopUser;

    /** @var string|null */
    private $token;

    public function __construct()
    {
        $this->comparerProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function hasProduct(ProductInterface $product): bool
    {
        /** @var ArrayCollection $result */
        $result = $this->comparerProducts->filter(function (ComparerProductInterface $comparerProduct) use ($product) {
            return $product === $comparerProduct->getProduct();
        });

        return !$result->isEmpty();
    }

    public function getProducts(): Collection
    {
        /** @var ArrayCollection $products */
        $products = $this->comparerProducts->map(function (ComparerProductInterface $comparerProduct) {
            return $comparerProduct->getProduct();
        });

        return $products;
    }

    public function hasComparerProduct(ComparerProductInterface $comparerProduct): bool
    {
        return $this->comparerProducts->contains($comparerProduct);
    }

    public function getComparerProduct(ProductInterface $product): ?ComparerProductInterface
    {
        /** @var ComparerProductInterface $comparerProduct */
        foreach ($this->getComparerProducts() as $comparerProduct) {
            if ($comparerProduct->getProduct() === $product) {
                return $comparerProduct;
            }
        }

        return null;
    }

    public function getComparerProducts(): Collection
    {
        return $this->comparerProducts;
    }

    public function getNumberOfProductsInComparer(): int
    {
        return $this->getProducts()->count();
    }

    public function addComparerProduct(ComparerProductInterface $comparerProduct): bool
    {
        if ($this->hasProduct($comparerProduct->getProduct())) {
            return false;
        }

        $comparerProduct->setComparer($this);
        $this->comparerProducts->add($comparerProduct);

        return true;
    }

    public function getComparerAttributes(Collection $products, string $locale, string $defaultLocale): ?Collection
    {
        $attributes = new ArrayCollection();
        /** @var ProductInterface $product */
        foreach ($products as $product) {
            foreach ($product->getAttributesByLocale(
                $locale,
                $defaultLocale
            ) as $attribute) {
                if (!$attributes->contains($attribute->getName())) {
                    $attributes->add($attribute->getName());
                }
            }
        }

        return $attributes;
    }

    public function getToken(): string
    {
        return (string) $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getShopUser(): ShopUserInterface
    {
        return $this->shopUser;
    }

    public function setShopUser(ShopUserInterface $shopUser): void
    {
        $this->shopUser = $shopUser;
    }
}
