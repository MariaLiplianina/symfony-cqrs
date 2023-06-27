<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Validation;

use App\Modules\Survey\Application\Validation\Constraint\SurveyUniqueNameConstraint;
use App\Modules\Survey\Infrastructure\Repository\SurveyRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class SurveyUniqueNameConstraintValidator extends ConstraintValidator
{
    public function __construct(private readonly SurveyRepository $surveyRepository)
    {
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof SurveyUniqueNameConstraint) {
            throw new \RuntimeException(__METHOD__ . ': !$constraint instanceof SurveyUniqueNameConstraint');
        }

        if (is_null($value)) {
            return;
        }

        if (!is_string($value)) {
            throw new \RuntimeException(__METHOD__ . ': !$constraint instanceof SurveyUniqueNameConstraint');
        }

        $survey = $this->surveyRepository->findByName($value);
        if ($survey) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
