<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Collection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

/**
 * search in data base for games with specific critera 
 *
 * @param string|null $searchTermn
 * @param Category|null $category
 * @param Collection|null $tags
 * @return mixed[]
 */
    public function search(?string $searchTermn, ?Category $category, ?Collection $tags) : array
    {
        $query =  $this->createQueryBuilder('game');

        if ($searchTermn) {
            $query->andWhere('game.name LIKE :searchTerm')
                ->setParameter('searchTerm', "%$searchTermn%");
            dump('search');
        }

        if ($category) {
            $query->andWhere('game.category IN (:cat)')
                  ->setParameter('cat', $category->getId());
            dump('category');
        }
        if ($tags) {
            $query->leftJoin('game.tags', 't');

            foreach ($tags as $tag) {
                $query->andWhere('t.id IN (:tags)')
                      ->setParameter('tags', $tag->getId());
            }
        }
        return $query->getQuery()
            ->getArrayResult();
    }

    // /**
    //  * @return Game[] Returns an array of Game objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Game
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}