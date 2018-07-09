<?php

declare(strict_types=1);

namespace spec\Locastic\SyliusComparerPlugin\Context;

use Locastic\SyliusComparerPlugin\Context\ComparerContext;
use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Locastic\SyliusComparerPlugin\Factory\ComparerFactoryInterface;
use Locastic\SyliusComparerPlugin\Repository\ComparerRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ShopUserInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class ComparerContextSpec extends ObjectBehavior
{
    function let(
        TokenStorageInterface $tokenStorage,
        ComparerFactoryInterface $comparerFactory,
        ComparerRepositoryInterface $comparerRepository
    ) {
        $this->beConstructedWith(
            $tokenStorage,
            $comparerFactory,
            $comparerRepository,
            'comparer_plugin_token'
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ComparerContext::class);
    }

    function it_creates_new_comparer_if_no_cookie_and_user(
        Request $request,
        ParameterBag $parameterBag,
        TokenStorageInterface $tokenStorage,
        TokenInterface $token,
        ComparerFactoryInterface $comparerFactory,
        ComparerInterface $comparer
    ): void {
        $request->cookies = $parameterBag;
        $parameterBag->get('comparer_plugin_token')->willReturn(null);
        $tokenStorage->getToken()->willReturn($token);
        $token->getUser()->willReturn(null);
        $comparerFactory->createNew()->willReturn($comparer);
        $this->getComparer($request)->shouldReturn($comparer);
    }

    function it_returns_cookie_comparer_if_cookie_and_no_user(
        Request $request,
        ParameterBag $parameterBag,
        TokenStorageInterface $tokenStorage,
        TokenInterface $token,
        ComparerRepositoryInterface $comparerRepository,
        ComparerInterface $comparer
    ): void {
        $request->cookies = $parameterBag;
        $parameterBag->get('comparer_plugin_token')->willReturn('Fq8N4W6mk12i9J2HX0U60POGG5UEzSgGW37OWd6sv2dd8FlBId');
        $tokenStorage->getToken()->willReturn($token);
        $token->getUser()->willReturn(null);
        $comparerRepository->findByToken('Fq8N4W6mk12i9J2HX0U60POGG5UEzSgGW37OWd6sv2dd8FlBId')->willReturn($comparer);
        $this->getComparer($request)->shouldReturn($comparer);
    }

    function it_returns_new_comparer_if_cookie_not_found_and_no_user(
        Request $request,
        ParameterBag $parameterBag,
        TokenStorageInterface $tokenStorage,
        TokenInterface $token,
        ComparerRepositoryInterface $comparerRepository,
        ComparerFactoryInterface $comparerFactory,
        ComparerInterface $comparer
    ): void {
        $request->cookies = $parameterBag;
        $parameterBag->get('comparer_plugin_token')->willReturn('Fq8N4W6mk12i9J2HX0U60POGG5UEzSgGW37OWd6sv2dd8FlBId');
        $tokenStorage->getToken()->willReturn($token);
        $token->getUser()->willReturn(null);
        $comparerRepository->findByToken('Fq8N4W6mk12i9J2HX0U60POGG5UEzSgGW37OWd6sv2dd8FlBId')->willReturn(null);
        $comparerFactory->createNew()->willReturn($comparer);
        $this->getComparer($request)->shouldReturn($comparer);
    }

    function it_returns_user_comparer_if_found_and_user_logged_in(
        Request $request,
        ParameterBag $parameterBag,
        TokenStorageInterface $tokenStorage,
        TokenInterface $token,
        ShopUserInterface $shopUser,
        ComparerRepositoryInterface $comparerRepository,
        ComparerInterface $comparer
    ): void {
        $request->cookies = $parameterBag;
        $parameterBag->get('comparer_plugin_token')->willReturn(null);
        $tokenStorage->getToken()->willReturn($token);
        $token->getUser()->willReturn($shopUser);
        $comparerRepository->findByShopUser($shopUser)->willReturn($comparer);
        $this->getComparer($request)->shouldReturn($comparer);
    }

    function it_returns_new_comparer_if_not_found_and_user_logged_in(
        Request $request,
        ParameterBag $parameterBag,
        TokenStorageInterface $tokenStorage,
        TokenInterface $token,
        ShopUserInterface $shopUser,
        ComparerRepositoryInterface $comparerRepository,
        ComparerFactoryInterface $comparerFactory,
        ComparerInterface $comparer
    ): void {
        $request->cookies = $parameterBag;
        $parameterBag->get('comparer_plugin_token')->willReturn(null);
        $tokenStorage->getToken()->willReturn($token);
        $token->getUser()->willReturn($shopUser);
        $comparerRepository->findByShopUser($shopUser)->willReturn(null);
        $comparerFactory->createForShopUser($shopUser)->willReturn($comparer);
        $this->getComparer($request)->shouldReturn($comparer);
    }
}
