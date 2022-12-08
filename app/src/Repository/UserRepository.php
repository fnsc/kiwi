<?php

namespace App\Repository;

use App\Domain\ValueObjects\SearchTerm;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findBySearchTerm(array $searchTerms): array
    {
        $query = $this->createQueryBuilder('user');

        foreach ($searchTerms as $key => $searchTerm) {
            if ($key === 0) {
                $query = $query->andWhere('user.first_name LIKE :value')
                    ->orWhere('user.last_name LIKE :value')
                    ->orWhere('user.email LIKE :value')
                    ->setParameter('value', '%' . $searchTerm->getTerm() . '%');
            }

            $query = $query->orWhere('user.first_name LIKE :value')
                    ->orWhere('user.last_name LIKE :value')
                    ->orWhere('user.email LIKE :value')
                    ->setParameter('value', '%' . $searchTerm->getTerm() . '%');
        }

        return $query->orderBy('user.first_name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findExact(SearchTerm $searchTerm): ?User
    {
        return $this->createQueryBuilder('user')
            ->andWhere('user.email = :value')
            ->setParameter('value',  $searchTerm->getTerm())
            ->getQuery()
            ->getOneOrNullResult();
    }
}
