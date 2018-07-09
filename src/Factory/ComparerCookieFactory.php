<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Factory;

use Symfony\Component\HttpFoundation\Cookie;

class ComparerCookieFactory implements ComparerCookieFactoryInterface
{
    /** @var string */
    private $comparerCookieToken;

    public function __construct(string $comparerCookieToken)
    {
        $this->comparerCookieToken = $comparerCookieToken;
    }

    public function createNew(string $token, string $duration = '+1 year'): Cookie
    {
        return new Cookie($this->comparerCookieToken, $token, strtotime($duration));
    }
}
