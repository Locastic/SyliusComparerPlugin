<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Controller\Action;

use Doctrine\ORM\EntityManagerInterface;
use Locastic\SyliusComparerPlugin\Context\ComparerContextInterface;
use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

final class ListComparerProductsAction
{
    /** @var EngineInterface */
    private $templatingEngine;

    /** @var EntityManagerInterface */
    private $comparerManager;

    /** @var ComparerContextInterface */
    private $comparerContext;

    /** @var string */
    private $comparerCookieToken;

    public function __construct(
        EngineInterface $templatingEngine,
        EntityManagerInterface $comparerManager,
        ComparerContextInterface $comparerContext,
        string $comparerCookieToken
    ) {
        $this->templatingEngine = $templatingEngine;
        $this->comparerManager = $comparerManager;
        $this->comparerContext = $comparerContext;
        $this->comparerCookieToken = $comparerCookieToken;
    }

    public function __invoke(Request $request): Response
    {
        /** @var ComparerInterface $comparer */
        $comparer = $this->comparerContext->getComparer($request);

        /** @var ProductInterface $product */
        $products = $comparer->getProducts();
        $attributes = $comparer->getComparerAttributes($products, $request->getLocale(), $request->getDefaultLocale());

        return new Response($this->templatingEngine->render(
                '@LocasticSyliusComparerPlugin/listComparer.html.twig', [
                    'products' => $comparer->getProducts(),
                    'attributes' => $attributes,
                ]
        ));
    }
}
