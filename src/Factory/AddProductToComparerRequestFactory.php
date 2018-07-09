<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Factory;

use Locastic\SyliusComparerPlugin\Context\ComparerContextInterface;
use Locastic\SyliusComparerPlugin\Request\AddProductToComparerRequest;
use Locastic\SyliusComparerPlugin\Request\ComparerRequestInterface;
use Symfony\Component\HttpFoundation\Request;

final class AddProductToComparerRequestFactory implements ComparerRequestFactoryInterface
{
    /** @var ComparerContextInterface */
    private $comparerContext;

    public function __construct(ComparerContextInterface $comparerContext)
    {
        $this->comparerContext = $comparerContext;
    }

    public function create(Request $request): ComparerRequestInterface
    {
        return new AddProductToComparerRequest(
            $request->get('productId'),
            $this->comparerContext->getComparer($request)
        );
    }
}
