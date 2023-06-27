<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Command\UseCase\Survey\AnswerSurvey;

use App\Modules\Survey\Domain\Entity\Answer;
use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\Infrastructure\Repository\SurveyRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AnswerSurveyHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly SurveyRepository $surveyRepository,
    ) {
    }

    public function __invoke(AnswerSurveyCommand $command): Survey
    {
        $survey = $this->surveyRepository->find($command->getSurveyId());

        $answer = new Answer(
            $command->getInput()->getQuality(),
            $survey
        );

        $answer->setComment($command->getInput()->getComment() ?: null);
        $survey->addAnswer($answer);

        return $survey;
    }
}
