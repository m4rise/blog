<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function allOrderedPostsQuery(): Query
    {
        return $this->findLatestPosts()
            ->getQuery();
    }

    public static function createIsValidatedCommentCriteria (): Criteria
    {
        return Criteria::create()
            ->andWhere(Criteria::expr()->eq('isValidated', true))
            ->orderBy(['createdAt' => 'DESC']);
    }

    private function findLatestPosts(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.updatedAt', 'DESC');
    }
}
