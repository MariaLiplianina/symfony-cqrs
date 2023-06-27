<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Command\UseCase\Survey\DeleteSurvey;

use App\Modules\Survey\Infrastructure\Repository\SurveyRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteSurveyHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly SurveyRepository $surveyRepository,
    ) {
    }

    public function __invoke(DeleteSurveyCommand $command): void
    {
        $survey = $this->surveyRepository->find($command->getSurveyId());

        $this->surveyRepository->remove($survey);
    }
}
