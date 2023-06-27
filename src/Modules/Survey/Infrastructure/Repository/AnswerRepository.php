<?php

namespace App\Modules\Survey\Infrastructure\Repository;

use App\Modules\Invoice\Domain\Entity\Invoice;
use App\Modules\Survey\Domain\Entity\Answer;
use App\Modules\Survey\Domain\Entity\Survey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Survey>
 *
 * @method Answer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Answer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Answer[]    findAll()
 * @method Answer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Answer::class);
    }

    public function getCountAndQualityBySurvey(Survey $survey): array
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('COUNT(a.id) as count, SUM(a.quality) as sum')
            ->from(Answer::class, 'a');

        $qb->andWhere('a.survey = :survey');
        $qb->setParameter('survey', $survey);

        return $qb->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY)[0];
    }

    /**
     * @param Survey $survey
     * @return array<int, string>
     */
    public function getCommentsBySurvey(Survey $survey): array
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('a.comment')
            ->from(Answer::class, 'a');

        $qb->andWhere('a.survey = :survey');
        $qb->setParameter('survey', $survey);
        $qb->andWhere('a.comment IS NOT NULL');

        return $qb->getQuery()->getResult(AbstractQuery::HYDRATE_SCALAR);
    }
}
