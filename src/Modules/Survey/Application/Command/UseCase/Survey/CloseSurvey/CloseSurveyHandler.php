<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Command\UseCase\Survey\CloseSurvey;

use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\Domain\Event\SurveyClosedEvent;
use App\Modules\Survey\Infrastructure\Repository\SurveyRepository;
use App\SharedKernel\Domain\Bus\EventBus;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CloseSurveyHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly SurveyRepository   $surveyRepository,
        private readonly EventBus $eventBus,
    ) {
    }

    public function __invoke(CloseSurveyCommand $command): Survey
    {
        $survey = $this->surveyRepository->find($command->getSurveyId());
        $survey->close();

        $this->eventBus->dispatch(
            new SurveyClosedEvent($command->getSurveyId()),
            true
        );

        return $survey;
    }
}
