<?php

declare(strict_types=1);

namespace Locastic\SyliusComparerPlugin\Validator\Constraints;

use Locastic\SyliusComparerPlugin\Utils\ComparerCapacityCheckerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class ComparerNotEmptyValidator extends ConstraintValidator
{
    /** @var ComparerCapacityCheckerInterface */
    private $capacityChecker;

    public function __construct(ComparerCapacityCheckerInterface $capacityChecker)
    {
        $this->capacityChecker = $capacityChecker;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if ($this->capacityChecker->isComparerEmpty($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
