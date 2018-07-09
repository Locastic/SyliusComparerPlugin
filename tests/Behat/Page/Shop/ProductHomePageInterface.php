<?php

declare(strict_types=1);

namespace Tests\Locastic\SyliusComparerPlugin\Behat\Page\Shop;

use Sylius\Behat\Page\Shop\HomePageInterface;

interface ProductHomePageInterface extends HomePageInterface
{
    public function addProductToComparer(string $productName): void;
}
