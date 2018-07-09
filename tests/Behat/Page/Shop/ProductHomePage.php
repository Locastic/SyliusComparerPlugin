<?php

declare(strict_types=1);

namespace Tests\Locastic\SyliusComparerPlugin\Behat\Page\Shop;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Page\Shop\HomePage;

class ProductHomePage extends HomePage implements ProductHomePageInterface
{
    public function addProductToComparer(string $productName): void
    {
        $this->open();
        $this->getSession()->setCookie('MOCKSESSID', 'foo');
        $comparerElements = $this->getDocument()->findAll('css', '.locastic-add-to-comparer ');
        /** @var NodeElement $comparerElement */
        foreach ($comparerElements as $comparerElement) {
            if ($productName === $comparerElement->getAttribute('data-product-name')) {
                $comparerElement->click();

                return;
            }
        }
    }
}
