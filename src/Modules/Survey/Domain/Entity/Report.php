<?php

declare(strict_types=1);

namespace App\Modules\Survey\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use App\Modules\Survey\Infrastructure\Repository\ReportRepository;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: ReportRepository::class)]
class Report
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private UuidInterface $id;

    #[ORM\Column]
    private int $numberOfAnswers;

    #[ORM\Column]
    private int $quality;

    #[ORM\Column(type: Types::JSON)]
    private array $comments;

    #[ORM\Column]
    private \DateTimeImmutable $generatedAt;

    #[ORM\OneToOne(inversedBy: 'report')]
    #[ORM\JoinColumn('survey_id', unique: true, nullable: false)]
    #[Ignore]
    private Survey $survey;

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNumberOfAnswers(): int
    {
        return $this->numberOfAnswers;
    }

    public function setNumberOfAnswers(int $numberOfAnswers): self
    {
        $this->numberOfAnswers = $numberOfAnswers;

        return $this;
    }

    public function getQuality(): int
    {
        return $this->quality;
    }

    public function setQuality(int $quality): self
    {
        $this->quality = $quality;

        return $this;
    }

    public function getComments(): array
    {
        return $this->comments;
    }

    public function setComments(array $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getGeneratedAt(): \DateTimeImmutable
    {
        return $this->generatedAt;
    }

    public function setGeneratedAt(\DateTimeImmutable $generatedAt): self
    {
        $this->generatedAt = $generatedAt;

        return $this;
    }

    public function getSurvey(): Survey
    {
        return $this->survey;
    }

    public function setSurvey(Survey $survey): self
    {
        $this->survey = $survey;

        return $this;
    }
}
