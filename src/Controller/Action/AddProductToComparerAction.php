<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Controller\Action;

use Locastic\SyliusComparerPlugin\Entity\ComparerProductInterface;
use Locastic\SyliusComparerPlugin\Factory\ComparerCookieFactoryInterface;
use Locastic\SyliusComparerPlugin\Factory\ComparerProductFactoryInterface;
use Locastic\SyliusComparerPlugin\Factory\ComparerRequestFactoryInterface;
use Locastic\SyliusComparerPlugin\Repository\ComparerRepositoryInterface;
use Locastic\SyliusComparerPlugin\Request\ComparerRequestInterface;
use Locastic\SyliusComparerPlugin\Utils\ComparerCapacityCheckerInterface;
use Locastic\SyliusComparerPlugin\Utils\MessageRedirectHelperInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class AddProductToComparerAction
{
    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var ComparerRepositoryInterface */
    private $comparerRepository;

    /** @var MessageRedirectHelperInterface */
    private $redirectHelper;

    /** @var ComparerProductFactoryInterface */
    private $comparerProductFactory;

    /** @var ComparerCapacityCheckerInterface */
    private $comparerItemChecker;

    /** @var ComparerCookieFactoryInterface */
    private $comparerCookieFactory;

    /** @var ValidatorInterface */
    private $validator;

    /** @var ComparerRequestFactoryInterface */
    private $comparerRequestFactory;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ComparerRepositoryInterface $comparerRepository,
        MessageRedirectHelperInterface $redirectHelper,
        ComparerProductFactoryInterface $comparerProductFactory,
        ComparerCapacityCheckerInterface $comparerItemChecker,
        ComparerCookieFactoryInterface $comparerCookieFactory,
        ValidatorInterface $validator,
        ComparerRequestFactoryInterface $comparerRequestFactory
    ) {
        $this->productRepository = $productRepository;
        $this->comparerRepository = $comparerRepository;
        $this->redirectHelper = $redirectHelper;
        $this->comparerProductFactory = $comparerProductFactory;
        $this->comparerItemChecker = $comparerItemChecker;
        $this->comparerCookieFactory = $comparerCookieFactory;
        $this->validator = $validator;
        $this->comparerRequestFactory = $comparerRequestFactory;
    }

    public function __invoke(Request $request): Response
    {
        /** @var ComparerRequestInterface */
        $addProductToComparerRequest = $this->comparerRequestFactory->create($request);

        /** @var ConstraintViolationListInterface $errors */
        $errors = $this->validator->validate($addProductToComparerRequest);

        if (count($errors)) {
            return $this->redirectHelper->warningRedirect($errors->get(0)->getMessage(), 'locastic_sylius_comparer_list_products');
        }

        $comparer = $addProductToComparerRequest->getComparer();

        /** @var ProductInterface $product */
        $product = $this->productRepository->find($request->get('productId'));

        /** @var ComparerProductInterface $comparerProduct */
        $comparerProduct = $this->comparerProductFactory->createForComparerAndProduct($comparer, $product);

        $comparer->addComparerProduct($comparerProduct);
        $this->comparerRepository->add($comparer);

        return $this->createResponseWithCookie($comparer->getToken());
    }

    public function createResponseWithCookie(string $token): RedirectResponse
    {
        $response = $this->redirectHelper->confirmationRedirect('locastic_sylius_comparer_plugin.ui.added_to_comparer', 'locastic_sylius_comparer_list_products');
        $response->headers->setCookie($this->comparerCookieFactory->createNew($token));

        return $response;
    }
}
