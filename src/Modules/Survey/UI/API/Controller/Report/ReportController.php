<?php

declare(strict_types=1);

namespace App\Modules\Survey\UI\API\Controller\Report;

use App\Modules\Survey\Application\Query\UseCase\ListSurvey\ListSurveyQuery;
use App\Modules\Survey\Application\Query\UseCase\ShowReport\ShowReportQuery;
use App\Modules\Survey\Domain\Entity\Report;
use App\SharedKernel\Infrastructure\Bus\MessengerQueryBus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    public function __construct(
        private readonly MessengerQueryBus $queryBus,
    ) {
    }

    #[Route('/report/{id}', methods: 'GET')]
    #[ParamConverter('report', Report::class)]
    public function show(Report $report): JsonResponse
    {
        $envelope = $this->queryBus->dispatch(new ShowReportQuery($report->getId()->toString()));

        return $this->json(
            $envelope->last(HandledStamp::class)->getResult()
        );
    }
}
