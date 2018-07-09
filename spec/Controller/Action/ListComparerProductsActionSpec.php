<?php

declare(strict_types=1);

namespace spec\Locastic\SyliusComparerPlugin\Controller\Action;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Locastic\SyliusComparerPlugin\Context\ComparerContextInterface;
use Locastic\SyliusComparerPlugin\Controller\Action\ListComparerProductsAction;
use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ListComparerProductsActionSpec extends ObjectBehavior
{
    function let(
        EngineInterface $templatingEngine,
        EntityManagerInterface $comparerManager,
        ComparerContextInterface $comparerContext
    ): void {
        $this->beConstructedWith(
            $templatingEngine,
            $comparerManager,
            $comparerContext,
            'comparer_plugin_token' //this will act as a cookie (phpspec requires an object or a manually created non-object
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ListComparerProductsAction::class);
    }

    function it_lists_comparer_items(
        Request $request,
        Collection $products,
        Collection $attributes,
        ComparerInterface $comparer,
        EngineInterface $templatingEngine,
        ComparerContextInterface $comparerContext
    ): void {
        $locale = 'hr';
        $defaultLocale = 'en';

        $comparerContext->getComparer($request)->willReturn($comparer);
        $comparer->getProducts()->willReturn($products);

        $request->getLocale()->willReturn($locale);
        $request->getDefaultLocale()->willReturn($defaultLocale);

        $comparer->getComparerAttributes($products, 'hr', 'en')->willReturn($attributes);

        $templatingEngine->render(
            '@LocasticSyliusComparerPlugin/listComparer.html.twig', [
                'products' => $products,
                'attributes' => $attributes,
            ]
        )->shouldBeCalled();

        $this->__invoke($request)->shouldHaveType(Response::class);
    }
}
