<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Utils;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

class MessageRedirectHelper implements MessageRedirectHelperInterface
{
    /** @var FlashBagInterface */
    private $flashBag;

    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    /** @var TranslatorInterface */
    private $translator;

    public function __construct(
        FlashBagInterface $flashBag,
        UrlGeneratorInterface $urlGenerator,
        TranslatorInterface $translator
    ) {
        $this->flashBag = $flashBag;
        $this->urlGenerator = $urlGenerator;
        $this->translator = $translator;
    }

    public function warningRedirect(string $messageTranslation, string $routeName): RedirectResponse
    {
        $this->flashBag->add('error', $this->translator->trans($messageTranslation));

        return new RedirectResponse($this->urlGenerator->generate($routeName));
    }

    public function confirmationRedirect(string $messageTranslation, string $routeName): RedirectResponse
    {
        $this->flashBag->add('success', $this->translator->trans($messageTranslation));

        return new RedirectResponse($this->urlGenerator->generate($routeName));
    }
}
