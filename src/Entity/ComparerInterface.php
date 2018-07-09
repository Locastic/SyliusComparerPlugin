<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface ComparerInterface extends ResourceInterface
{
    public function hasProduct(ProductInterface $product): bool;

    public function getProducts(): Collection;

    public function hasComparerProduct(ComparerProductInterface $comparerProduct): bool;

    public function getComparerProduct(ProductInterface $product): ?ComparerProductInterface;

    public function getComparerProducts(): Collection;

    public function getNumberOfProductsInComparer(): int;

    public function addComparerProduct(ComparerProductInterface $comparerProduct): bool;

    public function getComparerAttributes(Collection $products, string $locale, string $defaultLocale): ?Collection;

    public function getToken(): string;

    public function setToken(string $token): void;

    public function getShopUser(): ShopUserInterface;

    public function setShopUser(ShopUserInterface $shopUser): void;
}
