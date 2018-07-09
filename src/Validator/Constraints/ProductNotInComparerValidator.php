<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Validator\Constraints;

use Locastic\SyliusComparerPlugin\Request\AddProductToComparerRequest;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class ProductNotInComparerValidator extends ConstraintValidator
{
    /** @var ProductRepositoryInterface */
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param AddProductToComparerRequest $requestData
     * @param Constraint $constraint
     */
    public function validate($requestData, Constraint $constraint)
    {
        /** @var ProductInterface $product */
        $product = $this->productRepository->findOneBy(['id' => $requestData->getProductId()]);
        $comparer = $requestData->getComparer();
        if ($comparer->hasProduct($product)) {
            $this->context->buildViolation($constraint->message)
                ->atPath('productExistsMessage')
                ->setParameter('{{ product }}', $product->getName())
                ->addViolation();
        }
    }
}
