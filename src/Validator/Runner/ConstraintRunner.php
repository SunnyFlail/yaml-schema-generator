<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Runner;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Validator\Constraint\ArrayTypeConstraint;
use SunnyFlail\YamlSchemaGenerator\Validator\Constraint\Constraint;
use SunnyFlail\YamlSchemaGenerator\Validator\Constraint\ObjectTypeConstraint;
use SunnyFlail\YamlSchemaGenerator\Validator\Exception\ConstraintsFailedException;

final readonly class ConstraintRunner implements ConstraintRunnerInterface
{
    public function run(Mapping $mapping): void
    {
        $violations = [];

        foreach ($this->getConstraints() as $constraint) {
            if ($constraint->supports($mapping)) {
                foreach ($constraint->validate($mapping) as $violation) {
                    $violations[] = $violation;
                }
            }
        }

        if ($violations) {
            throw new ConstraintsFailedException($mapping, ...$violations);
        }
    }

    /**
     * @return iterable<Constraint>
     */
    private function getConstraints(): iterable
    {
        yield new ArrayTypeConstraint();
        yield new ObjectTypeConstraint();
    }
}
