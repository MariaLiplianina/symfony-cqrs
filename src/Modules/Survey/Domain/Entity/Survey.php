<?php

declare(strict_types=1);

namespace App\Modules\Survey\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use App\Modules\Survey\Infrastructure\Repository\SurveyRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: SurveyRepository::class)]
#[UniqueEntity(fields: 'name', errorPath: 'name')]
class Survey
{
    public const STATUS_NEW = 'new';
    public const STATUS_LIVE = 'live';
    public const STATUS_CLOSED = 'closed';

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private UuidInterface $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 32)]
    private string $status;

    #[ORM\OneToMany(
        mappedBy: 'survey',
        targetEntity: Answer::class,
        cascade: ['persist'],
        fetch: 'EXTRA_LAZY',
        orphanRemoval: true
    )]
    private Collection $answers;

    #[ORM\OneToOne(mappedBy: 'survey', cascade: ['persist', 'remove'])]
    #[Ignore]
    private ?Report $report = null;

    #[ORM\Column(length: 255)]
    private string $reportEmail;

    public function __construct(string $name, string $reportEmail)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->reportEmail = $reportEmail;

        $this->status = self::STATUS_NEW;
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function open(): self
    {
        if ($this->status !== self::STATUS_NEW) {
            throw new \LogicException('Survey is not new');
        }

        $this->status = self::STATUS_LIVE;

        return $this;
    }

    public function close(): self
    {
        if ($this->status !== self::STATUS_LIVE) {
            throw new \LogicException('Survey is not live');
        }

        $this->status = self::STATUS_CLOSED;

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
        }

        return $this;
    }

    public function getReport(): ?Report
    {
        return $this->report;
    }

    public function setReport(Report $report): self
    {
        $this->report = $report;

        return $this;
    }

    public function getReportEmail(): string
    {
        return $this->reportEmail;
    }

    public function setReportEmail(string $reportEmail): self
    {
        $this->reportEmail = $reportEmail;

        return $this;
    }
}
