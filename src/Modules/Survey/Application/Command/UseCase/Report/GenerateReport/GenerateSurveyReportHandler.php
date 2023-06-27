<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Command\UseCase\Report\GenerateReport;

use App\Modules\Survey\Application\Service\ReportGenerator;
use App\Modules\Survey\Domain\Event\ReportGeneratedEvent;
use App\Modules\Survey\Infrastructure\Repository\SurveyRepository;
use App\SharedKernel\Domain\Bus\EventBus;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GenerateSurveyReportHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly ReportGenerator $reportGenerator,
        private readonly SurveyRepository $surveyRepository,
        private readonly EventBus $eventBus,
    ) {
    }

    public function __invoke(GenerateSurveyReportCommand $command): void
    {
        $survey = $this->surveyRepository->find($command->getSurveyId());

        $report = $this->reportGenerator->generate($survey);

        $this->eventBus->dispatch(new ReportGeneratedEvent($report->getId()->toString()));
    }
}
