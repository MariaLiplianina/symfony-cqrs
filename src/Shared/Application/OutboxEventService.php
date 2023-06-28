<?php

declare(strict_types=1);

namespace App\Shared\Application;

use App\Shared\Domain\Entity\OutboxEvent;
use App\Shared\Infrastructure\OutboxEventRepository;
use App\SharedKernel\Domain\Bus\AsyncEvent;

class OutboxEventService
{
    public function __construct(private readonly OutboxEventRepository $outboxEventRepository)
    {
    }

    public function create(AsyncEvent $event): void
    {
        $event = new OutboxEvent($event::class, array($event));

        $this->outboxEventRepository->save($event);
    }
}
