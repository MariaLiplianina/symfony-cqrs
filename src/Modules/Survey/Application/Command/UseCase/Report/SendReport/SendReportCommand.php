<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Command\UseCase\Report\SendReport;

use App\SharedKernel\Domain\Bus\AsyncCommand;

class SendReportCommand implements AsyncCommand
{
    public function __construct(private readonly string $reportId)
    {
    }

    public function getReportId(): string
    {
        return $this->reportId;
    }
}
