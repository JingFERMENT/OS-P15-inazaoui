<?php

namespace App\Repository;

use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Media>
 */
class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }

    /** @return list<Media> $result */
    public function findForActiveGuests(): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $ids = $connection->fetchFirstColumn(
            'SELECT m.id FROM media m
            INNER JOIN "user" u ON u.id = m.user_id 
            WHERE u.is_active = true 
            AND ((u.roles::jsonb) @> :guest::jsonb)
            ORDER BY m.id ASC',
            ['guest' => '["ROLE_GUEST"]']
        );

        /** @var list<Media> $result */
        $result = $this->createQueryBuilder('m')
            ->andWhere('m.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult();

        return $result;
    }
}
