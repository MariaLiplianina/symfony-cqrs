<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Command\UseCase\Report\GenerateReport;

use App\SharedKernel\Domain\Bus\AsyncCommand;

class GenerateSurveyReportCommand implements AsyncCommand
{
    public function __construct(private readonly string $surveyId)
    {
    }

    public function getSurveyId(): string
    {
        return $this->surveyId;
    }
}
