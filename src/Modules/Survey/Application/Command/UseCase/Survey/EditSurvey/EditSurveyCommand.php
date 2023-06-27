<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Command\UseCase\Survey\EditSurvey;

use App\SharedKernel\Domain\Bus\Command;

class EditSurveyCommand implements Command
{
    public function __construct(private readonly string $surveyId, private readonly EditSurveyCommandInput $input)
    {
    }

    public function getInput(): EditSurveyCommandInput
    {
        return $this->input;
    }

    public function getSurveyId(): string
    {
        return $this->surveyId;
    }
}
