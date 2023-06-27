<?php

declare(strict_types=1);

namespace App\Modules\Survey\Domain\Event;

use App\Modules\Survey\Domain\Entity\Survey;
use App\SharedKernel\Domain\Bus\AsyncEvent;

class SurveyClosedEvent implements AsyncEvent
{
    public function __construct(private readonly string $surveyId)
    {
    }

    public function getSurveyId(): string
    {
        return $this->surveyId;
    }
}
