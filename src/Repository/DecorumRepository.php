<?php

namespace App\Repository;

use App\Entity\Decorum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Decorum>
 *
 * @method Decorum|null find($id, $lockMode = null, $lockVersion = null)
 * @method Decorum|null findOneBy(array $criteria, array $orderBy = null)
 * @method Decorum[]    findAll()
 * @method Decorum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DecorumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Decorum::class);
    }

    public function save(Decorum $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findAllDESC(): array
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC');



        $query = $qb->getQuery();

        return $query->execute();

    }

    public function findAllUnique($id,$marque): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Decorum p
            WHERE (p.id != :id) and (p.marque = :marque)'
        )->setParameter('id',$id)
        ->setParameter('marque',$marque);

        return $query->getResult();
    }

    public function remove(Decorum $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Decorum[] Returns an array of Decorum objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Decorum
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
