<?php

declare(strict_types=1);

namespace App\Modules\Survey\UI\API\Controller\Survey;

use App\Modules\Survey\Application\Query\UseCase\ListSurvey\ListSurveyQuery;
use App\Modules\Survey\UI\API\BaseController;
use App\SharedKernel\Infrastructure\Bus\MessengerQueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class ListSurveyController extends BaseController
{
    public function __construct(private readonly MessengerQueryBus $queryBus)
    {
    }

    #[Route('/survey', methods: 'GET')]
    public function list(): JsonResponse
    {
        $envelope = $this->queryBus->dispatch(new ListSurveyQuery());

        return $this->json(
            $envelope->last(HandledStamp::class)->getResult()
        );
    }
}
