<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Utils;

use Symfony\Component\HttpFoundation\RedirectResponse;

interface MessageRedirectHelperInterface
{
    public function warningRedirect(string $message, string $route): RedirectResponse;

    public function confirmationRedirect(string $message, string $route): RedirectResponse;
}
