<?php
/**
 * Created by PhpStorm.
 * User: lele
 * Date: 13/07/17
 * Time: 16:56
 */

namespace Tests\AppBundle\Service;


use AppBundle\Repository\TirelireRepository;
use AppBundle\Service\TransactionChecker;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class TransactionCheckerTest extends TestCase
{

    private $objectManager;
    private $transacChecker;

    public function setUp()
    {

        // Creation de notre EntityManager Factice
        $this->objectManager = $this->createMock(EntityManager::class);
        // Creation de notre Repository Factice
        $tirelireRepository = $this->createMock(TirelireRepository::class);
        // Mise en place de notre valeur fixe que nous retourne la Methode getTotalAmount
        $tirelireRepository->expects($this->any())
            ->method('getTotalAmount')
            ->willReturn(100);
        // Mise en place de notre "faux" repository comme objet retourné par
        // l'appel de getRepository sur notre "faux" entityManager
        $this->objectManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($tirelireRepository);

        $this->transacChecker = new TransactionChecker($this->objectManager);

        //parent::__construct();
    }

    /**
     *
     *  Test a successful transaction
     *
     * @dataProvider transactionsSuccessProvider
     */
    public function testSuccess($amount)
    {
        $this->assertTrue($this->transacChecker->isAllowed($amount));
    }


    /**
     *  Test a failed transaction cause amount money is not enough
     *
     *
     */
    public function testFailure()
    {
        $this->assertFalse($this->transacChecker->isAllowed(-125));
    }


    public  function transactionsSuccessProvider()
    {
        return [
            'adding some money to my account'  => [25],
            'taking 25 to my account'  => [-25],
        ];
    }

}