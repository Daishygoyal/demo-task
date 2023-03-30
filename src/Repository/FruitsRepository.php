<?php

namespace App\Repository;

use App\Entity\Fruits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fruits>
 *
 * @method Fruits|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fruits|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fruits[]    findAll()
 * @method Fruits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FruitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fruits::class);
    }

    public function save(Fruits $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Fruits $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Fruits[] Returns an array of Fruits objects
     */
    public function getPaginatedFruits($page, $name, $family): array
    {
        $query = $this->createQueryBuilder('f');
        if($name!=''){
            $query->andWhere('f.name = :name')
            ->setParameter('name', $name);
        }
        if($family!=''){
            $query->andWhere('f.family = :family')
                ->setParameter('family', $family);
        }
        $query->getQuery();
        $pageSize = '10';
        $fruits = new Paginator($query);
        $totalItems = count($fruits);
        $pagesCount = ceil($totalItems / $pageSize);
        $fruits
            ->getQuery()
            ->setFirstResult($pageSize * ($page-1))
            ->setMaxResults($pageSize)->getArrayResult();
        return [
            'pagesCount'=>$pagesCount,
            'totalItems'=>$totalItems,
            'fruits'=>$fruits->getIterator(),
        ];
    }

    public function getPaginatedFavourites($page): array
    {
        $query = $this->createQueryBuilder('f')
            ->andWhere('f.isFavourite = :val')
            ->setParameter('val', true)
            ->getQuery();
        $pageSize = '10';
        $fruits = new Paginator($query);
        $totalItems = count($fruits);
        $pagesCount = ceil($totalItems / $pageSize);

        $fruits
            ->getQuery()
            ->setFirstResult($pageSize * ($page-1))
            ->setMaxResults($pageSize)->getArrayResult();
        return [
            'pagesCount'=>$pagesCount,
            'totalItems'=>$totalItems,
            'fruits'=>$fruits->getIterator(),
        ];
    }

//    public function findOneBySomeField($value): ?Fruits
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
