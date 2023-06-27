<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Command\UseCase\Survey\AnswerSurvey;

use App\SharedKernel\Domain\Bus\Command;

class AnswerSurveyCommand implements Command
{
    public function __construct(private readonly string $surveyId, private readonly AnswerSurveyCommandInput $input)
    {
    }

    public function getInput(): AnswerSurveyCommandInput
    {
        return $this->input;
    }

    public function getSurveyId(): string
    {
        return $this->surveyId;
    }
}
