<?php

declare(strict_types=1);

namespace App\Modules\Survey\UI\API\Controller\Survey;

use App\Modules\Survey\Application\Command\UseCase\Survey\AnswerSurvey\AnswerSurveyCommandInput;
use App\Modules\Survey\Application\Service\AnswerSurveyService;
use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\UI\API\BaseController;
use App\Shared\Domain\Exception\ValidationFailedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AnswerSurveyController extends BaseController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly AnswerSurveyService $answerSurveyService
    ) {
    }

    #[Route('/survey/{id}/answer', methods: 'POST')]
    #[ParamConverter('survey', Survey::class)]
    public function add(Survey $survey, Request $request): JsonResponse
    {
        $input = $this->serializer->deserialize(
            $request->getContent(),
            AnswerSurveyCommandInput::class,
            'json'
        );

        try {
            $response = $this->answerSurveyService->process($survey, $input);
        } catch (\Exception $e) {
            if ($e instanceof ValidationFailedException) {
                return $this->jsonValidationError($e->getViolationList());
            }

            return $this->jsonError($e->getMessage());
        }

        return $this->json($response);
    }
}
