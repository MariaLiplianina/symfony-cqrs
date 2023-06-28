<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Bus;

use App\SharedKernel\Domain\Bus\AsyncEvent;
use App\SharedKernel\Domain\Bus\Event;
use App\SharedKernel\Domain\Bus\EventBus;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

final class MessengerEventBus implements EventBus
{
    public function __construct(
        private readonly MessageBusInterface $eventBus,
    ) {
    }

    public function dispatch(Event|AsyncEvent $event, bool $dispatchAfterCurrentBus = false): void
    {
        $envelope = $dispatchAfterCurrentBus ?
            (new Envelope($event))->with(new DispatchAfterCurrentBusStamp())
            : new Envelope($event);

        $this->eventBus->dispatch($envelope);
    }
}
