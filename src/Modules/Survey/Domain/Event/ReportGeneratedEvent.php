<?php

namespace App\Modules\Survey\Domain\Event;

use App\Modules\Survey\Domain\Entity\Report;
use App\SharedKernel\Domain\Bus\AsyncEvent;

class ReportGeneratedEvent implements AsyncEvent
{

    public function __construct(private readonly string $reportId)
    {
    }

    public function getReportId(): string
    {
        return $this->reportId;
    }
}
