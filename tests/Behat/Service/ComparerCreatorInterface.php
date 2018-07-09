<?php

declare(strict_types=1);

namespace Tests\Locastic\SyliusComparerPlugin\Behat\Service;

use Sylius\Component\Core\Model\ShopUserInterface;

interface ComparerCreatorInterface
{
    public function createComparerWithProductAndUser(ShopUserInterface $shopUser, string $productName): void;

    public function createFullComparer(): void;
}
