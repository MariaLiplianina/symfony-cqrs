<?php

namespace App\Shared\Infrastructure;

use App\Modules\Survey\Domain\Entity\Survey;
use App\Shared\Domain\Entity\OutboxEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Survey>
 *
 * @method OutboxEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method OutboxEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method OutboxEvent[]    findAll()
 * @method OutboxEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OutboxEventRepository extends ServiceEntityRepository
{
    public function save(OutboxEvent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
