<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Validation\Constraint;

use App\Modules\Survey\Application\Validation\SurveyUniqueNameConstraintValidator;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class SurveyUniqueNameConstraint extends Constraint
{

    public string $message = 'Survey with this name already exists.';

    public function validatedBy(): string
    {
        return SurveyUniqueNameConstraintValidator::class;
    }
}
