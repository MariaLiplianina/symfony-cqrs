<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Command\UseCase\Report\SendReport;

use App\Modules\Survey\Application\Service\ReportMailer;
use App\Modules\Survey\Infrastructure\Repository\ReportRepository;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SendReportHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly ReportRepository $reportRepository,
        private readonly ReportMailer $reportMailer,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function __invoke(SendReportCommand $command): void
    {
        $report = $this->reportRepository->find($command->getReportId());

        $this->reportMailer->send($report);
    }
}
