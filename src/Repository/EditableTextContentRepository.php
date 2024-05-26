<?php

namespace App\Repository;

use App\Entity\EditableTextContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EditableTextContent>
 *
 * @method EditableTextContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method EditableTextContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method EditableTextContent[]    findAll()
 * @method EditableTextContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EditableTextContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EditableTextContent::class);
    }

//    /**
//     * @return EditableTextContent[] Returns an array of EditableTextContent objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EditableTextContent
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
