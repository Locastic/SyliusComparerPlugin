<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Repository;

use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ShopUserInterface;

class ComparerRepository extends EntityRepository implements ComparerRepositoryInterface
{
    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByShopUser(ShopUserInterface $shopUser): ?ComparerInterface
    {
        return $this->createQueryBuilder('comparer')
            ->where('comparer.shopUser = :shopUser')
            ->setParameter('shopUser', $shopUser)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByToken(string $token): ?ComparerInterface
    {
        return $this->createQueryBuilder('comparer')
            ->where('comparer.token = :token')
            ->setParameter('token', $token)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
