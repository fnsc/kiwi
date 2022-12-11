<?php

namespace App\Repository;

use App\Domain\ValueObjects\Filter;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
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

    /**
     * @param array<Filter> $searchTerms
     * @return array
     */
    public function findBySearchTerm(array $searchTerms): array
    {
        $query = $this->createQueryBuilder('user');

        foreach ($searchTerms as $key => $searchTerm) {
            if ($key === 0) {
                $query = $query->andWhere('user.first_name LIKE :value')
                    ->orWhere('user.last_name LIKE :value')
                    ->setParameter('value', '%' . $searchTerm->getValue() . '%')
                    ->orWhere('user.id = :value')
                    ->setParameter('value', $searchTerm->getValue());

                continue;
            }

            $query = $query->orWhere('user.first_name LIKE :value')
                    ->orWhere('user.last_name LIKE :value')
                    ->setParameter('value', '%' . $searchTerm->getValue() . '%')
                    ->orWhere('user.id = :value')
                    ->setParameter('value', $searchTerm->getValue());
        }

        return $query->orderBy('user.first_name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findExact(Filter $searchTerm): array
    {
        return $this->createQueryBuilder('user')
            ->andWhere('user.first_name LIKE :value')
            ->setParameter('value', $searchTerm->getValue() . '%')
            ->orderBy('user.first_name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array<Filter> $filters
     * @return array
     */
    public function findExactWithCountry(array $filters): array
    {
        $query = $this->createQueryBuilder('user');

        $query->select('users')
            ->from(User::class, 'users')
            ->innerJoin('user.address', 'addresses', Join::WITH, 'addresses.user_id = users.id');

        foreach ($filters as $filter) {
            if ($filter->getName() === 'country') {
                $query->andWhere('addresses.country = :country')
                    ->setParameter('country', $filter->getValue());

                continue;
            }

            $query = $query->andWhere('user.first_name LIKE :value')
                ->setParameter('value', $filter->getValue() . '%');
        }

        return $query->orderBy('user.first_name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
