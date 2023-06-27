<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Bus;

use App\SharedKernel\Domain\Bus\AsyncCommand;
use App\SharedKernel\Domain\Bus\Command;
use App\SharedKernel\Domain\Bus\CommandBus;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCommandBus implements CommandBus
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
    ) {
    }

    public function dispatch(Command|AsyncCommand $command): Envelope
    {
        $envelope = new Envelope($command);

        return $this->commandBus->dispatch($envelope);
    }
}
