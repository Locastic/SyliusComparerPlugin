<?php

declare(strict_types=1);

namespace spec\Locastic\SyliusComparerPlugin\Utils;

use Locastic\SyliusComparerPlugin\Entity\ComparerInterface;
use Locastic\SyliusComparerPlugin\Utils\ComparerCapacityChecker;
use Locastic\SyliusComparerPlugin\Utils\ComparerCapacityCheckerInterface;
use PhpSpec\ObjectBehavior;

final class ComparerCapacityCheckerSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(3);    //lets say there can be 3 products in the comparer
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ComparerCapacityChecker::class);
    }

    function it_should_implement_comparer_capacity_checker_interface()
    {
        $this->shouldHaveType(ComparerCapacityCheckerInterface::class);
    }

    function it_checks_is_comparer_full_when_it_is_not(ComparerInterface $comparer)
    {
        $comparer->getNumberOfProductsInComparer()->willReturn(2);

        $this->isComparerFilled($comparer)->shouldReturn(false);
    }

    function it_checks_is_comparer_full_when_it_is(ComparerInterface $comparer)
    {
        $comparer->getNumberOfProductsInComparer()->willReturn(3);

        $this->isComparerFilled($comparer)->shouldReturn(true);
    }
}
