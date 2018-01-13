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
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class TransactionCheckerTest extends TestCase
{

    const REF_AMOUNT = 100;

    private $fakeEntityManager;
    private $transactionChecker;

    public function setUp()
    {

        // Create our fake EntityManager
        $this->fakeEntityManager = $this->createMock(EntityManager::class);
        // Create our FAKE Repository #STOCK
        $tirelireRepository = $this->createMock(TirelireRepository::class);
        // Define fixed reference value returned by getTotalAmount #MOCK
        $tirelireRepository->expects($this->any())
            ->method('getTotalAmount')
            ->willReturn(self::REF_AMOUNT);
        // Setting up our "fake" repository as an object returned by
        // the call of getRepository on our "fake" fakeEntityManager
        $this->fakeEntityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($tirelireRepository);

        $this->transactionChecker = new TransactionChecker($this->fakeEntityManager);

    }

    /**
     *
     *  Test a successful transaction
     *
     * @dataProvider transactionsSuccessProvider
     */
    public function testSuccess($amount)
    {
        $this->assertTrue($this->transactionChecker->isAllowed($amount));
    }


    /**
     *  Test a failed transaction cause amount money is not enough
     *
     *
     */
    public function testFailure()
    {
        $this->assertFalse($this->transactionChecker->isAllowed(-125));
    }


    /**
     *  Test a successful set of data for transaction cause amount money is not enough
     *
     *
     */
    public  function transactionsSuccessProvider()
    {
        return [
            'adding some money to my account'  => [25],
            'taking 25 to my account'  => [-25],
        ];
    }

}
