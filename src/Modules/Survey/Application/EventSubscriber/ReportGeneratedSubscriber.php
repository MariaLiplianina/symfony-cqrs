<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\EventSubscriber;

use App\Modules\Survey\Application\Command\UseCase\Report\SendReport\SendReportCommand;
use App\Modules\Survey\Domain\Event\ReportGeneratedEvent;
use App\SharedKernel\Domain\Bus\CommandBus;
use App\SharedKernel\Infrastructure\Bus\MessengerCommandBus;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ReportGeneratedSubscriber implements MessageHandlerInterface
{
    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    public function __invoke(ReportGeneratedEvent $event): void
    {
        $this->commandBus->dispatch(
            new SendReportCommand($event->getReportId())
        );
    }
}
