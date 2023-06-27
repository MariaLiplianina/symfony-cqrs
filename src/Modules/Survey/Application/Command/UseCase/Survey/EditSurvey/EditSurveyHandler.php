<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Command\UseCase\Survey\EditSurvey;

use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\Infrastructure\Repository\SurveyRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class EditSurveyHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly SurveyRepository $surveyRepository,
    ) {
    }

    public function __invoke(EditSurveyCommand $command): Survey
    {
        $survey = $this->surveyRepository->find($command->getSurveyId());

        if ($command->getInput()->getName()) {
            $survey->setName($command->getInput()->getName());
        }

        if ($command->getInput()->getReportEmail()) {
            $survey->setReportEmail($command->getInput()->getReportEmail());
        }

        return $survey;
    }
}
