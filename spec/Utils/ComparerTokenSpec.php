<?php

declare(strict_types=1);

namespace spec\Locastic\SyliusComparerPlugin\Entity;

use Locastic\SyliusComparerPlugin\Utils\ComparerToken;
use Locastic\SyliusComparerPlugin\Utils\ComparerTokenInterface;
use PhpSpec\ObjectBehavior;

final class ComparerTokenSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ComparerToken::class);
    }

    function it_implements_comparer_token_interface()
    {
        $this->shouldHaveType(ComparerTokenInterface::class);
    }

    function it_provides_token_value()
    {
        $this->provide()->shouldBeString();
    }
}
