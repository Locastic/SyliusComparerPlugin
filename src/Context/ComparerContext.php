<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Context;

use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Locastic\SyliusComparerPlugin\Factory\ComparerFactoryInterface;
use Locastic\SyliusComparerPlugin\Repository\ComparerRepositoryInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class ComparerContext implements ComparerContextInterface
{
    /** @var TokenStorageInterface */
    private $tokenStorage;

    /** @var ComparerRepositoryInterface */
    private $comparerRepository;

    /** @var ComparerFactoryInterface */
    private $comparerFactory;

    /** @var string */
    private $comparerCookieToken;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        ComparerFactoryInterface $comparerFactroy,
        ComparerRepositoryInterface $comparerRepository,
        string $comparerCookieToken
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->comparerFactory = $comparerFactroy;
        $this->comparerRepository = $comparerRepository;
        $this->comparerCookieToken = $comparerCookieToken;
    }

    public function getComparer(Request $request): ComparerInterface
    {
        $cookieComparerToken = $request->cookies->get($this->comparerCookieToken);
        $token = $this->tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;

        if ($this->userIsLoggedIn($user)) {
            return $this->comparerRepository->findByShopUser($user) ??
                $this->comparerFactory->createForShopUser($user);
        }

        if ($this->guestUserHasComparer($cookieComparerToken, $user)) {
            return $this->comparerRepository->findByToken($cookieComparerToken) ??
                $this->comparerFactory->createNew();
        }

        return $this->comparerFactory->createNew();
    }

    private function userIsLoggedIn($user)
    {
        return $user instanceof ShopUserInterface;
    }

    private function guestUserHasComparer(?string $cookieComparerToken, $user): bool
    {
        if (null !== $cookieComparerToken && !$user instanceof ShopUserInterface) {
            return true;
        }

        return false;
    }
}
