<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Factory;

use Locastic\SyliusComparerPlugin\Context\ComparerContextInterface;
use Locastic\SyliusComparerPlugin\Request\ComparerRequestInterface;
use Locastic\SyliusComparerPlugin\Request\RemoveProductFromComparerRequest;
use Symfony\Component\HttpFoundation\Request;

class RemoveProductFromComparerRequestFactory implements ComparerRequestFactoryInterface
{
    /** @var ComparerContextInterface */
    private $comparerContext;

    public function __construct(ComparerContextInterface $comparerContext)
    {
        $this->comparerContext = $comparerContext;
    }

    public function create(Request $request): ComparerRequestInterface
    {
        return new RemoveProductFromComparerRequest(
            $request->get('productId'),
            $this->comparerContext->getComparer($request)
        );
    }
}
