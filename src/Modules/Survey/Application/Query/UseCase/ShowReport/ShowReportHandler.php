<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Query\UseCase\ShowReport;

use App\Modules\Survey\Application\Query\UseCase\ListSurvey\ListSurveyQuery;
use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\Infrastructure\Repository\ReportRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ShowReportHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly ReportRepository $reportRepository,
    ) {
    }

    /**
     * @param ListSurveyQuery $query
     * @return Survey[]
     */
    public function __invoke(ShowReportQuery $query): array
    {
        $report = $this->reportRepository->find($query->getReportId());

        return [
            'survey' => $report->getSurvey()->getId()->toString(),
            'numberOfAnswers' => $report->getNumberOfAnswers(),
            'quality' => $report->getQuality(),
            'generatedAt' => $report->getGeneratedAt()->format('Y-m-d'),
            'comments' => $report->getComments(),
        ];
    }
}
