<?php
/**
 * Created by PhpStorm.
 * User: Ahmed
 * Date: 20/12/2018
 * Time: 22:18
 */

namespace App\Tests\Controller\Repository;

use App\Entity\PhoneBook;
use App\Repository\PhoneBookRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PhoneBookRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testFindByPhoneOrName()
    {
        $phonesBook = $this->entityManager
            ->getRepository(PhoneBook::class)
            ->findByPhoneOrName('Ahmed')
        ;

        $this->assertCount(1, $phonesBook);

    }
}
