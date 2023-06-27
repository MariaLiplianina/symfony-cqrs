<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Command\UseCase\Survey\CreateSurvey;

use App\SharedKernel\Domain\Bus\Command;

class CreateSurveyCommand implements Command
{
    public function __construct(private readonly CreateSurveyCommandInput $input)
    {
    }

    public function getInput(): CreateSurveyCommandInput
    {
        return $this->input;
    }
}
