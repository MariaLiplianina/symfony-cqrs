<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Bus;

use App\SharedKernel\Domain\Bus\AsyncEvent;
use App\SharedKernel\Domain\Bus\Event;
use App\SharedKernel\Domain\Bus\EventBus;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerEventBus implements EventBus
{
    public function __construct(
        private readonly MessageBusInterface $eventBus,
    ) {
    }

    public function dispatch(Event|AsyncEvent $event): void
    {
        $envelope = new Envelope($event);
        $this->eventBus->dispatch($envelope);
    }
}
