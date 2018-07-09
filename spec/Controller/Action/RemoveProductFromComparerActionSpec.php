<?php


declare(strict_types=1);

namespace spec\Locastic\SyliusComparerPlugin\Controller\Action;

use Locastic\SyliusComparerPlugin\Controller\Action\RemoveProductFromComparerAction;
use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Locastic\SyliusComparerPlugin\Entity\ComparerProductInterface;
use Locastic\SyliusComparerPlugin\Factory\ComparerRequestFactoryInterface;
use Locastic\SyliusComparerPlugin\Request\ComparerRequestInterface;
use Locastic\SyliusComparerPlugin\Utils\MessageRedirectHelperInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RemoveProductFromComparerActionSpec extends ObjectBehavior
{
    function let(
        RepositoryInterface $comparerProductRepository,
        MessageRedirectHelperInterface $redirectHelper,
        ProductRepositoryInterface $productRepository,
        ValidatorInterface $validator,
        ComparerRequestFactoryInterface $comparerRequestFactory
    ): void {
        $this->beConstructedWith(
            $comparerProductRepository,
            $redirectHelper,
            $productRepository,
            $validator,
            $comparerRequestFactory
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RemoveProductFromComparerAction::class);
    }

    function it_throws_404_if_error_occured(
        Request $request,
        ComparerRequestFactoryInterface $comparerRequestFactory,
        ComparerRequestInterface $removeRequest,
        ConstraintViolationListInterface $errors,
        ValidatorInterface $validator,
        ConstraintViolationInterface $constraintViolation,
        MessageRedirectHelperInterface $redirectHelper
    ): void {
        $comparerRequestFactory->create($request)->willReturn($removeRequest);
        $validator->validate($removeRequest)->willReturn($errors);

        $errors->get(0)->willReturn($constraintViolation);
        $constraintViolation->getMessage()->willReturn('err');

        $errors->count()->willReturn(1);
        $redirectHelper->warningRedirect('err', 'locastic_sylius_comparer_list_products');

        $this->__invoke($request)->shouldHaveType(RedirectResponse::class);
        $removeRequest->getComparer()->shouldNotBeCalled();
    }

    function it_handles_request_and_redirects_to_comparer(
        Request $request,
        ProductRepositoryInterface $productRepository,
        ProductInterface $product,
        ComparerRequestFactoryInterface $comparerRequestFactory,
        ComparerRequestInterface $removeRequest,
        RepositoryInterface $comparerRepositoryInterface,
        ComparerInterface $comparer,
        ComparerProductInterface $comparerProduct,
        ValidatorInterface $validator,
        ConstraintViolationListInterface $errors,
        MessageRedirectHelperInterface $redirectHelper,
        RedirectResponse $redirectResponse
    ): void {
        $comparerRequestFactory->create($request)->willReturn($removeRequest);

        $validator->validate($removeRequest)->willReturn($errors);
        $errors->count()->willReturn(0);

        $removeRequest->getComparer()->willReturn($comparer);

        $request->get('productId')->willReturn(1);
        $productRepository->find(1)->willReturn($product);

        $comparer->getComparerProduct($product)->willReturn($comparerProduct);
        $comparerRepositoryInterface->remove($comparerProduct);
        $redirectHelper
            ->confirmationRedirect('locastic_sylius_comparer_plugin.ui.removed_from_comparer', 'locastic_sylius_comparer_list_products')
            ->willReturn($redirectResponse)
        ;

        $this->__invoke($request)->shouldHaveType(RedirectResponse::class);
    }
}
