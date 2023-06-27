<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Command\UseCase\Survey\OpenSurvey;

use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\Infrastructure\Repository\SurveyRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class OpenSurveyHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly SurveyRepository $surveyRepository,
    ) {
    }

    public function __invoke(OpenSurveyCommand $command): Survey
    {
        $survey = $this->surveyRepository->find($command->getSurveyId());
        $survey->open();

        return $survey;
    }
}
