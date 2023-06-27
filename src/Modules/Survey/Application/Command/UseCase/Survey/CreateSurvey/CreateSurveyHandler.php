<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Command\UseCase\Survey\CreateSurvey;

use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\Infrastructure\Repository\SurveyRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateSurveyHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly SurveyRepository $surveyRepository,
    ) {
    }


    public function __invoke(CreateSurveyCommand $command): Survey
    {
        $survey = new Survey(
            $command->getInput()->getName(),
            $command->getInput()->getReportEmail()
        );

        $this->surveyRepository->save($survey);

        return $survey;
    }
}
