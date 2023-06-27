<?php

declare(strict_types=1);

namespace App\Modules\Survey\UI\API\Controller\Survey;

use App\Modules\Survey\Application\Service\CloseSurveyService;
use App\Modules\Survey\Application\Service\OpenSurveyService;
use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\UI\API\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LifecycleSurveyController extends BaseController
{
    public function __construct(
        private readonly CloseSurveyService $closeSurveyService,
        private readonly OpenSurveyService $openSurveyService,
    ) {
    }

    #[Route('/survey/{id}/open', methods: 'PUT')]
    #[ParamConverter('survey', Survey::class)]
    public function open(
        Survey $survey
    ): JsonResponse {
        try {
            $response = $this->openSurveyService->process($survey);
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage());
        }

        return $this->json($response);
    }

    #[Route('/survey/{id}/close', methods: 'PUT')]
    #[ParamConverter('survey', Survey::class)]
    public function close(
        Survey $survey
    ): JsonResponse {
        try {
            $response = $this->closeSurveyService->process($survey);
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage());
        }

        return $this->json($response);
    }
}
