<?php

namespace App\Repository;

use App\Entity\PhoneBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PhoneBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhoneBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhoneBook[]    findAll()
 * @method PhoneBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhoneBookRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PhoneBook::class);
    }

    public function findByPhoneOrName($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name LIKE :value OR p.phone LIKE :value')
            ->setParameter('value', '%'.$value.'%')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
