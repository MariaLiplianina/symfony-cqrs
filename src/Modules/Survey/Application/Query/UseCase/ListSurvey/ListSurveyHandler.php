<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Query\UseCase\ListSurvey;

use App\Modules\Survey\Domain\Entity\Answer;
use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\Infrastructure\Repository\SurveyRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ListSurveyHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly SurveyRepository $surveyRepository,
    ) {
    }

    /**
     * @param ListSurveyQuery $query
     * @return Survey[]
     */
    public function __invoke(ListSurveyQuery $query): array
    {
        $surveys = $this->surveyRepository->findAll();

        return array_map(function (Survey $survey) {
            $answers = array_map(function (Answer $answer) {
                return [
                    'quality' => $answer->getQuality(),
                    'comment' => $answer->getComment(),
                ];
            }, $survey->getAnswers()->toArray());

            return [
                'id' => $survey->getId(),
                'name' => $survey->getName(),
                'reportEmail' => $survey->getReportEmail(),
                'status' => $survey->getStatus(),
                'answers' => $answers,
            ];
        }, $surveys);
    }
}
