<?php

declare(strict_types=1);

namespace App\Modules\Survey\UI\API\Controller\Survey;

use App\Modules\Survey\Application\Service\DeleteSurveyService;
use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\UI\API\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteSurveyController extends BaseController
{
    public function __construct(private readonly DeleteSurveyService $deleteSurveyService)
    {
    }

    #[Route('/survey/{id}', methods: 'DELETE')]
    #[ParamConverter('survey', Survey::class)]
    public function delete(Survey $survey): JsonResponse
    {
        try {
            $this->deleteSurveyService->process($survey);
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage());
        }

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
