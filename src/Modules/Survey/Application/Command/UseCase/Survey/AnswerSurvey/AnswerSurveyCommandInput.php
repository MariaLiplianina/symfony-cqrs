<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Command\UseCase\Survey\AnswerSurvey;

use App\SharedKernel\Domain\Bus\Command;
use Symfony\Component\Validator\Constraints as Assert;

class AnswerSurveyCommandInput implements Command
{
    #[Assert\NotBlank]
    #[Assert\Range(min: -2, max: 2)]
    private int $quality;

    #[Assert\Blank(groups: ['positive'])]
    #[Assert\NotBlank(groups: ['negative'])]
    private ?string $comment = null;

    public function getQuality(): int
    {
        return $this->quality;
    }

    public function setQuality(int $quality): void
    {
        $this->quality = $quality;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }
}
