<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Service;

use App\Modules\Survey\Application\Command\UseCase\Survey\AnswerSurvey\AnswerSurveyCommand;
use App\Modules\Survey\Application\Command\UseCase\Survey\AnswerSurvey\AnswerSurveyCommandInput;
use App\Modules\Survey\Domain\Entity\Survey;
use App\Shared\Application\Exception\ValidationFailedException;
use App\SharedKernel\Domain\Bus\CommandBus;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AnswerSurveyService
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly CommandBus $commandBus,
    ) {
    }

    /**
     * @throws ValidationFailedException
     */
    public function process(Survey $survey, AnswerSurveyCommandInput $input): Survey
    {
        if ($survey->getStatus() !== Survey::STATUS_LIVE) {
            throw new \LogicException('Survey is not live');
        }

        $groups = $input->getQuality() < 0 ? ['negative'] : ['positive'];
        $violations = $this->validator->validate($input, null, $groups);
        if ($violations->count()) {
            throw new ValidationFailedException($violations);
        }

        $envelope = $this->commandBus->dispatch(new AnswerSurveyCommand($survey->getId()->toString(), $input));

        return $envelope->last(HandledStamp::class)->getResult();
    }
}
