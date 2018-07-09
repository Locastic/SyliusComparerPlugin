<?php

declare(strict_types=1);

namespace Tests\Locastic\SyliusComparerPlugin\Behat\Page\Shop;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Page\SymfonyPage;

class ComparerPage extends SymfonyPage implements ComparerPageInterface
{
    public function getItemsCount(): int
    {
        return (int) $this->getDocument()->find('css', '.comparer_item_limit')->getText();
    }

    public function hasProduct(string $productName): bool
    {
        $productElements = $this->getDocument()->findAll('css', '.sylius-product-name');
        /** @var NodeElement $productElement */
        foreach ($productElements as $productElement) {
            if ($productName === $productElement->getText()) {
                return true;
            }
        }

        return false;
    }

    public function removeProduct(string $productName): void
    {
        $comparerElements = $this->getDocument()->findAll('css', '.locastic-remove-from-comparer');
        /** @var NodeElement $comparerElement */
        foreach ($comparerElements as $comparerElement) {
            if ($productName === $comparerElement->getAttribute('data-product-name')) {
                $comparerElement->click();
            }
        }
    }

    public function addProductToCart(): void
    {
        $this->getDocument()->find('css', '.add_product_to_comparer');
    }

    public function hasProductInCart(string $productName): bool
    {
        $productNameOnPage = $this->getDocument()->find('css', '.ui.cart.popup > .list > .item > strong')->getText();

        return $productName === $productNameOnPage;
    }

    public function getRouteName(): string
    {
        return 'locastic_sylius_comparer_list_products';
    }
}
