<?php

declare(strict_types=1);

namespace App\Tests\Modules\Survey\Application\Service;

use App\Modules\Survey\Application\Command\UseCase\Survey\CreateSurvey\CreateSurveyCommand;
use App\Modules\Survey\Application\Command\UseCase\Survey\CreateSurvey\CreateSurveyCommandInput;
use App\Modules\Survey\Application\Command\UseCase\Survey\CreateSurvey\CreateSurveyHandler;
use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\Infrastructure\Repository\SurveyRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CreateSurveyCommandTest extends TestCase
{

    private const NAME = 'name';
    private const EMAIL = 'email@email.com';
    private const STATUS = Survey::STATUS_NEW;

    private CreateSurveyHandler|MockObject $createSurveyHandler;

    protected function setUp(): void
    {
        $surveyRepository = $this->getMockBuilder(SurveyRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->createSurveyHandler = new CreateSurveyHandler(
            $surveyRepository
        );
    }

    public function test()
    {
        $context = new CreateSurveyCommandInput();
        $context->setName('name');
        $context->setReportEmail('email@email.com');

        $command = new CreateSurveyCommand($context);
        $survey = ($this->createSurveyHandler)($command);

        self::assertSame(self::NAME, $survey->getName());
        self::assertSame(self::EMAIL, $survey->getReportEmail());
        self::assertSame(self::STATUS, $survey->getStatus());
    }
}
