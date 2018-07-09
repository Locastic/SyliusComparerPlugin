<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Controller\Action;

use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Locastic\SyliusComparerPlugin\Factory\ComparerRequestFactoryInterface;
use Locastic\SyliusComparerPlugin\Request\ComparerRequestInterface;
use Locastic\SyliusComparerPlugin\Utils\MessageRedirectHelperInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RemoveProductFromComparerAction
{
    /** @var RepositoryInterface */
    private $comparerProductRepository;

    /** @var MessageRedirectHelperInterface */
    private $redirectHelper;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var ValidatorInterface */
    private $validator;

    /** @var ComparerRequestFactoryInterface */
    private $comparerRequestFactory;

    public function __construct(
        RepositoryInterface $comparerProductRepository,
        MessageRedirectHelperInterface $redirectHelper,
        ProductRepositoryInterface $productRepository,
        ValidatorInterface $validator,
        ComparerRequestFactoryInterface $comparerRequestFactory
    ) {
        $this->comparerProductRepository = $comparerProductRepository;
        $this->redirectHelper = $redirectHelper;
        $this->productRepository = $productRepository;
        $this->validator = $validator;
        $this->comparerRequestFactory = $comparerRequestFactory;
    }

    public function __invoke(Request $request)
    {
        /** @var ComparerRequestInterface */
        $removeRequest = $this->comparerRequestFactory->create($request);

        $errors = $this->validator->validate($removeRequest);

        if (count($errors)) {
            return $this->redirectHelper->warningRedirect($errors->get(0)->getMessage(), 'locastic_sylius_comparer_list_products');
        }

        /** @var ComparerInterface */
        $comparer = $removeRequest->getComparer();

        /** @var ProductInterface $product */
        $product = $this->productRepository->find($request->get('productId'));

        $this->comparerProductRepository->remove($comparer->getComparerProduct($product));

        return $this->redirectHelper->confirmationRedirect('locastic_sylius_comparer_plugin.ui.removed_from_comparer', 'locastic_sylius_comparer_list_products');
    }
}
