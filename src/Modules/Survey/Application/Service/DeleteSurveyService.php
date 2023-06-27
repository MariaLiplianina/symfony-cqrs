<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Service;

use App\Modules\Survey\Application\Command\UseCase\Survey\DeleteSurvey\DeleteSurveyCommand;
use App\Modules\Survey\Domain\Entity\Survey;
use App\Shared\Exception\ValidationFailedException;
use App\SharedKernel\Domain\Bus\CommandBus;

class DeleteSurveyService
{
    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    /**
     * @throws ValidationFailedException
     */
    public function process(Survey $survey): void
    {
        if ($survey->getStatus() === Survey::STATUS_LIVE) {
            throw new \LogicException('Survey is live');
        }

        $this->commandBus->dispatch(new DeleteSurveyCommand($survey->getId()->toString()));
    }
}
