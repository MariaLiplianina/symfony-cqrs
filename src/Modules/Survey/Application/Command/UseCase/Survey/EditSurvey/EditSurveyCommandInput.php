<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Command\UseCase\Survey\EditSurvey;

use App\Modules\Survey\Application\Validation\Constraint\SurveyUniqueNameConstraint;
use App\SharedKernel\Domain\Bus\Command;
use Symfony\Component\Validator\Constraints as Assert;

class EditSurveyCommandInput implements Command
{
    #[SurveyUniqueNameConstraint]
    private ?string $name = null;

    #[Assert\Email]
    private ?string $reportEmail = null;

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function setReportEmail(?string $reportEmail): void
    {
        $this->reportEmail = $reportEmail;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getReportEmail(): ?string
    {
        return $this->reportEmail;
    }
}
