<?php

declare(strict_types=1);

namespace App\Shared\UI\Command;

use App\Shared\Infrastructure\OutboxEventRepository;
use App\SharedKernel\Domain\Bus\EventBus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:process-outbox-events',
    description: 'Push OutboxEvent to EventBus',
)]
class ProcessOutboxEventsCommand extends Command
{
    public function __construct(
        private readonly EventBus $eventBus,
        private readonly OutboxEventRepository $outboxEventRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $events = $this->outboxEventRepository->findAll();
        if (!$events) {
            return Command::SUCCESS;
        }

        foreach ($events as $event) {
            $this->eventBus->dispatch(new ($event->getName($event->getPayload())));

            $event->setProcessedAt(new \DateTimeImmutable());
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
