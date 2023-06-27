<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Service;

use App\Modules\Survey\Application\Command\UseCase\Survey\EditSurvey\EditSurveyCommand;
use App\Modules\Survey\Application\Command\UseCase\Survey\EditSurvey\EditSurveyCommandInput;
use App\Modules\Survey\Domain\Entity\Survey;
use App\Shared\Exception\ValidationFailedException;
use App\SharedKernel\Domain\Bus\CommandBus;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EditSurveyService
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly CommandBus $commandBus
    ) {
    }

    /**
     * @throws ValidationFailedException
     */
    public function process(Survey $survey, EditSurveyCommandInput $input): Survey
    {
        if ($survey->getStatus() !== Survey::STATUS_NEW) {
            throw new \LogicException('Survey is not new');
        }

        $violations = $this->validator->validate($input);
        if ($violations->count()) {
            throw new ValidationFailedException($violations);
        }

        $envelope = $this->commandBus->dispatch(new EditSurveyCommand($survey->getId()->toString(), $input));

        return $envelope->last(HandledStamp::class)->getResult();
    }
}
