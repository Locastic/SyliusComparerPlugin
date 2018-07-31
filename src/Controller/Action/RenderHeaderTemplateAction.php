<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Controller\Action;

use Locastic\SyliusComparerPlugin\Context\ComparerContextInterface;
use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

final class RenderHeaderTemplateAction
{
    /**
     * @var EngineInterface
     */
    private $templatingEngine;
    /**
     * @var ComparerContextInterface
     */
    private $comparerContext;

    public function __construct(EngineInterface $templatingEngine, ComparerContextInterface $comparerContext)
    {
        $this->templatingEngine = $templatingEngine;
        $this->comparerContext = $comparerContext;
    }

    public function __invoke(Request $request): Response
    {
        /** @var ComparerInterface $comparer */
        $comparer = $this->comparerContext->getComparer($request);

        return new Response(
            $this->templatingEngine->render('@LocasticSyliusComparerPlugin/_comparerItemCountHeader.html.twig', [
                'comparer' => $comparer
            ]
         ));
    }

}