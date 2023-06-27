<?php

declare(strict_types=1);

namespace App\Modules\Survey\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity]
#[Index(columns: ["comment"], name: "comment", options: ["where" => "(comment IS NOT NULL)"])]
class Answer
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private UuidInterface $id;

    #[ORM\Column]
    private int $quality;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\ManyToOne(inversedBy: 'answer')]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
    private Survey $survey;

    public function __construct(int $quality, Survey $survey)
    {
        $this->id = Uuid::uuid4();
        $this->quality = $quality;
        $this->survey = $survey;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getQuality(): int
    {
        return $this->quality;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getSurvey(): Survey
    {
        return $this->survey;
    }
}
