<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Bus;

use App\SharedKernel\Domain\Bus\Query;
use App\SharedKernel\Domain\Bus\QueryBus;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerQueryBus implements QueryBus
{
    public function __construct(
        private readonly MessageBusInterface $queryBus,
    ) {
    }

    public function dispatch(Query $query): Envelope
    {
        $envelope = new Envelope($query);

        return $this->queryBus->dispatch($envelope);
    }
}
