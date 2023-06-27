<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Service;

use App\Modules\Survey\Domain\Entity\Report;
use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\Infrastructure\Repository\AnswerRepository;
use App\Modules\Survey\Infrastructure\Repository\ReportRepository;
use App\Modules\Survey\Infrastructure\Repository\SurveyRepository;
use Ramsey\Uuid\Uuid;

final class ReportGenerator
{
    public function __construct(
        private readonly SurveyRepository $surveyRepository,
        private readonly AnswerRepository $answerRepository,
        private readonly ReportRepository $reportRepository,
    ) {
    }

    public function generate(Survey $survey): Report
    {
        $survey = $this->surveyRepository->find($survey->getId());

        $result = $this->answerRepository->getCountAndQualityBySurvey($survey);
        $comments = $this->answerRepository->getCommentsBySurvey($survey);

        $report = new Report();
        $report->setId(Uuid::uuid4());
        $report->setNumberOfAnswers($result['count']);
        $report->setSurvey($survey);
        $report->setGeneratedAt(new \DateTimeImmutable());
        $report->setQuality((int) ($result['sum'] / $result['count']));
        $report->setComments($comments);

        $survey->setReport($report);

        $this->reportRepository->save($report);

        return $report;
    }
}
