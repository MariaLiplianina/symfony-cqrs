<?php

declare(strict_types=1);

namespace App\Shared\Domain\Entity;

use App\Shared\Infrastructure\OutboxEventRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: OutboxEventRepository::class)]
class OutboxEvent
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private UuidInterface $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: "json")]
    private array $payload;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt ;

    #[ORM\Column]
    private ?\DateTimeImmutable $processedAt = null;

    public function __construct(string $name, array $payload)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->payload = $payload;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getProcessedAt(): ?\DateTimeImmutable
    {
        return $this->processedAt;
    }

    public function setProcessedAt(?\DateTimeImmutable $processedAt): void
    {
        $this->processedAt = $processedAt;
    }
}
