<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Query\UseCase\ShowReport;

use App\SharedKernel\Domain\Bus\Query;

class ShowReportQuery implements Query
{
    public function __construct(private readonly string $reportId)
    {
    }

    public function getReportId(): string
    {
        return $this->reportId;
    }
}
