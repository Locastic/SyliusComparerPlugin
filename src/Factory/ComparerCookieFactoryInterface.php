<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Factory;

use Symfony\Component\HttpFoundation\Cookie;

interface ComparerCookieFactoryInterface
{
    public function createNew(string $token, string $duration = '+1 year'): Cookie;
}
