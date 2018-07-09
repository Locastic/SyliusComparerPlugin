<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Repository;

use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface ComparerRepositoryInterface extends RepositoryInterface
{
    public function findByShopUser(ShopUserInterface $shopUser): ?ComparerInterface;

    public function findByToken(string $token): ?ComparerInterface;
}
