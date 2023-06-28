<?php

declare(strict_types=1);

namespace App\Modules\Survey\UI\API\Controller\Survey;

use App\Modules\Survey\Application\Command\UseCase\Survey\EditSurvey\EditSurveyCommandInput;
use App\Modules\Survey\Application\Service\EditSurveyService;
use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\UI\API\BaseController;
use App\Shared\Application\Exception\ValidationFailedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class EditSurveyController extends BaseController
{
    use HandleTrait;

    public function __construct(
        private readonly EditSurveyService $editSurveyService,
        private readonly SerializerInterface $serializer,
    ) {
    }

    #[Route('/survey/{id}', methods: 'PUT')]
    #[ParamConverter('survey', Survey::class)]
    public function edit(
        Survey $survey,
        Request $request,
    ): JsonResponse {
        $input = $this->serializer->deserialize(
            $request->getContent(),
            EditSurveyCommandInput::class,
            'json'
        );

        try {
            $response = $this->editSurveyService->process($survey, $input);
        } catch (\Exception $e) {
            if ($e instanceof ValidationFailedException) {
                return $this->jsonValidationError($e->getViolationList());
            }

            return $this->jsonError($e->getMessage());
        }

        return $this->json($response);
    }
}
