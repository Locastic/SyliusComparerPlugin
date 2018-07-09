<?php

declare(strict_types=1);

namespace Tests\Locastic\SyliusComparerPlugin\Behat\Page\Shop;

use Sylius\Behat\Page\SymfonyPageInterface;

interface ComparerPageInterface extends SymfonyPageInterface
{
    public function getItemsCount(): int;

    public function hasProduct(string $productName): bool;

    public function removeProduct(string $productName): void;

    public function addProductToCart(): void;

    public function hasProductInCart(string $productName): bool;
}
