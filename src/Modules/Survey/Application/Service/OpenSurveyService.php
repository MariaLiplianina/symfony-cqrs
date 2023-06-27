<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Service;

use App\Modules\Survey\Application\Command\UseCase\Survey\OpenSurvey\OpenSurveyCommand;
use App\Modules\Survey\Domain\Entity\Survey;
use App\SharedKernel\Domain\Bus\CommandBus;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class OpenSurveyService
{
    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    public function process(Survey $survey): Survey
    {
        if ($survey->getStatus() !== Survey::STATUS_NEW) {
            throw new \LogicException('Survey is not new');
        }

        $envelope = $this->commandBus->dispatch(
            new OpenSurveyCommand($survey->getId()->toString())
        );

        return $envelope->last(HandledStamp::class)->getResult();
    }
}
