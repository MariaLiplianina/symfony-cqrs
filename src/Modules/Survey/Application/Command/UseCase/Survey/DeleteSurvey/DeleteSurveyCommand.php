<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Command\UseCase\Survey\DeleteSurvey;

use App\SharedKernel\Domain\Bus\Command;

class DeleteSurveyCommand implements Command
{
    public function __construct(private readonly string $surveyId)
    {
    }

    public function getSurveyId(): string
    {
        return $this->surveyId;
    }
}
