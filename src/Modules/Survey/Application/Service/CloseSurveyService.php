<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Service;

use App\Modules\Survey\Application\Command\UseCase\Survey\CloseSurvey\CloseSurveyCommand;
use App\Modules\Survey\Domain\Entity\Survey;
use App\Shared\Application\Exception\ValidationFailedException;
use App\SharedKernel\Domain\Bus\CommandBus;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class CloseSurveyService
{
    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    /**
     * @throws ValidationFailedException
     */
    public function process(Survey $survey): Survey
    {
        if ($survey->getStatus() === Survey::STATUS_CLOSED) {
            throw new \LogicException('Survey is already closed');
        }

        $envelope = $this->commandBus->dispatch(new CloseSurveyCommand($survey->getId()->toString()));

        return $envelope->last(HandledStamp::class)->getResult();
    }
}
