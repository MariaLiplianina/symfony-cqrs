<?php

declare(strict_types=1);

namespace App\Modules\Survey\UI\API\Controller\Survey;

use App\Modules\Survey\Application\Command\UseCase\Survey\CreateSurvey\CreateSurveyCommandInput;
use App\Modules\Survey\Application\Service\CreateSurveyService;
use App\Modules\Survey\UI\API\BaseController;
use App\Shared\Exception\ValidationFailedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CreateSurveyController extends BaseController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly CreateSurveyService $createSurveyService
    ) {
    }

    #[Route('/survey', methods: 'POST')]
    public function create(Request $request): JsonResponse
    {
        $input = $this->serializer->deserialize(
            $request->getContent(),
            CreateSurveyCommandInput::class,
            'json'
        );

        try {
            $response = $this->createSurveyService->process($input);
        } catch (\Exception $e) {
            if ($e instanceof ValidationFailedException) {
                return $this->jsonValidationError($e->getViolationList());
            }

            return $this->jsonError($e->getMessage());
        }

        return $this->json($response, Response::HTTP_CREATED);
    }
}
