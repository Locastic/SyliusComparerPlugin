<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Validator\Constraints;

use Locastic\SyliusComparerPlugin\Utils\ComparerCapacityCheckerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ComparerNotFullValidator extends ConstraintValidator
{
    /** @var ComparerCapacityCheckerInterface */
    private $capacityChecker;

    public function __construct(ComparerCapacityCheckerInterface $capacityChecker)
    {
        $this->capacityChecker = $capacityChecker;
    }

    public function validate($comparer, Constraint $constraint)
    {
        if ($this->capacityChecker->isComparerFilled($comparer)) {
            $this->context
                ->buildViolation($constraint->message)
                ->atPath('comparerFullMessage')
                ->addViolation();
        }
    }
}
