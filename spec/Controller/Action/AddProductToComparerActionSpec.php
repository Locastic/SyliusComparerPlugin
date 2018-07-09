<?php

declare(strict_types=1);

namespace spec\Locastic\SyliusComparerPlugin\Controller\Action;

use Locastic\SyliusComparerPlugin\Controller\Action\AddProductToComparerAction;
use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Locastic\SyliusComparerPlugin\Entity\ComparerProductInterface;
use Locastic\SyliusComparerPlugin\Factory\ComparerCookieFactoryInterface;
use Locastic\SyliusComparerPlugin\Factory\ComparerProductFactoryInterface;
use Locastic\SyliusComparerPlugin\Factory\ComparerRequestFactoryInterface;
use Locastic\SyliusComparerPlugin\Repository\ComparerRepositoryInterface;
use Locastic\SyliusComparerPlugin\Request\ComparerRequestInterface;
use Locastic\SyliusComparerPlugin\Utils\ComparerCapacityCheckerInterface;
use Locastic\SyliusComparerPlugin\Utils\MessageRedirectHelperInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class AddProductToComparerActionSpec extends ObjectBehavior
{
    function let(
        ProductRepositoryInterface $productRepository,
        ComparerRepositoryInterface $comparerRepository,
        MessageRedirectHelperInterface $redirectHelper,
        ComparerProductFactoryInterface $comparerProductFactory,
        ComparerCapacityCheckerInterface $comparerItemChecker,
        ComparerCookieFactoryInterface $comparerCookieFactory,
        ValidatorInterface $validator,
        ComparerRequestFactoryInterface $comparerRequestFactory
    ): void {
        $this->beConstructedWith(
            $productRepository,
            $comparerRepository,
            $redirectHelper,
            $comparerProductFactory,
            $comparerItemChecker,
            $comparerCookieFactory,
            $validator,
            $comparerRequestFactory
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddProductToComparerAction::class);
    }

    function it_throws_404_if_product_was_not_found(
        Request $request,
        MessageRedirectHelperInterface $redirectHelper,
        ValidatorInterface $validator,
        ConstraintViolationListInterface $errors,
        ConstraintViolationInterface $constraintViolation,
        ComparerRequestFactoryInterface $comparerRequestFactory,
        ComparerRequestInterface $addProductToComparerRequest,
        RedirectResponse $redirectResponse
    ): void {
        $comparerRequestFactory->create($request)->willReturn($addProductToComparerRequest);
        $validator->validate($addProductToComparerRequest)->willReturn($errors);

        $errors->get(0)->willReturn($constraintViolation);
        $constraintViolation->getMessage()->willReturn('err');

        $errors->count()->willReturn(1);
        $redirectHelper->warningRedirect('err', 'locastic_sylius_comparer_list_products')->willReturn($redirectResponse);

        $this->__invoke($request)->shouldHaveType(RedirectResponse::class);
        $addProductToComparerRequest->getComparer()->shouldNotBeCalled();
    }

    function it_handles_the_request_and_persist_new_comparer_if_needed(
        Request $request,
        ProductRepositoryInterface $productRepository,
        ProductInterface $product,
        ComparerInterface $comparer,
        ComparerProductFactoryInterface $comparerProductFactory,
        ConstraintViolationListInterface $errors,
        ComparerProductInterface $comparerProduct,
        ComparerRequestFactoryInterface $comparerRequestFactory,
        ComparerRepositoryInterface $comparerRepository,
        ComparerRequestInterface $addProductToComparerRequest,
        ValidatorInterface $validator,
        MessageRedirectHelperInterface $redirectHelper,
        ComparerCookieFactoryInterface $comparerCookieFactory,
        ResponseHeaderBag $headerBag,
        $cookie,
        RedirectResponse $redirectResponse
    ): void {
        $comparerRequestFactory->create($request)->willReturn($addProductToComparerRequest);
        $validator->validate($addProductToComparerRequest)->willReturn($errors);
        $errors->count()->willReturn(0);

        $addProductToComparerRequest->getComparer()->willReturn($comparer);

        $request->get('productId')->willReturn(1);
        $productRepository->find(1)->willReturn($product);

        $comparerProductFactory->createForComparerAndProduct($comparer, $product)->willReturn($comparerProduct);
        $comparer->addComparerProduct($comparerProduct)->shouldBeCalled();
        $comparerRepository->add($comparer)->shouldBeCalled();

        $comparer->getToken()->willReturn('token');

        $redirectHelper
            ->confirmationRedirect('locastic_sylius_comparer_plugin.ui.added_to_comparer', 'locastic_sylius_comparer_list_products')
            ->willReturn($redirectResponse)
        ;

        $cookie->beADoubleOf('Symfony\Component\HttpFoundation\Cookie');
        $comparerCookieFactory->createNew('token')->willReturn($cookie);
        $redirectResponse->headers = $headerBag;
        $redirectResponse->headers->setCookie($cookie->getWrappedObject());

        $this->__invoke($request)->shouldHaveType(RedirectResponse::class);
    }
}
