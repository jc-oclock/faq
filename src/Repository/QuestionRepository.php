<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Question::class);
    }

    // /**
    //  * @return Question[] Returns an array of Question objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Question
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

      /**
     * EXO 1 : Récupérer la liste les films par ordre alphabétique
     * Méthode en DQL (Doctrine Query Language)
     * 
     *  @return Question[] Returns an array of Movie objects
     */
    public function findAllDQLOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT q
                FROM App\Entity\Question q 
                ORDER BY q.title ASC
            ')
            ->getResult();
    }
    /**
     * 
     * 
     *  @return Question[] Returns an array of Movie objects
     */
    public function findAllQueryBuilderOrderedByName()
    {
        $query = $this->createQueryBuilder('q')
                      ->orderBy('q.title', 'ASC'); // Ou ->add('orderBy', 'a.title ASC')
        return $query->getQuery()->getResult();
    }
    // retourne les derniers films avec nombre limité de résultats
    public function lastRelease($limit){
        $query = $this->createQueryBuilder('q')
                      ->orderBy('q.id', 'DESC')
                      ->setMaxResults( $limit );
        return $query->getQuery()->getResult();
    }
    // retourne la liste des films filtré par titre
    public function findByTitle($title){
        $query = $this->createQueryBuilder('q')
                      ->where('q.title LIKE :searchTitle')
                      ->setParameter('searchTitle', '%' . $title . '%')
                      ->orderBy('q.title', 'ASC'); 
        return $query->getQuery()->getResult();
    }
}
