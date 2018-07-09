<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

final class ProductNotInComparer extends Constraint
{
    public $message = 'locastic_sylius_comparer_plugin.ui.comparer_contains_added_product';

    public function validatedBy()
    {
        return get_class($this) . 'Validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
