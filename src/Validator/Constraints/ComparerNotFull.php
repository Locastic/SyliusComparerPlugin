<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

final class ComparerNotFull extends Constraint
{
    public $message = 'locastic_sylius_comparer_plugin.ui.comparer_full';

    public function validatedBy()
    {
        return get_class($this) . 'Validator';
    }

    public function getTargets()
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
