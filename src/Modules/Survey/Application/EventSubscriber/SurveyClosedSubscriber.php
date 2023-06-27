<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\EventSubscriber;

use App\Modules\Survey\Application\Command\UseCase\Report\GenerateReport\GenerateSurveyReportCommand;
use App\Modules\Survey\Domain\Event\SurveyClosedEvent;
use App\SharedKernel\Domain\Bus\CommandBus;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SurveyClosedSubscriber implements MessageHandlerInterface
{

    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    public function __invoke(SurveyClosedEvent $event): void
    {
        $this->commandBus->dispatch(
            new GenerateSurveyReportCommand($event->getSurveyId())
        );
    }
}
