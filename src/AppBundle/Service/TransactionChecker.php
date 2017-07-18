<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;

/**
 * Created by PhpStorm.
 * User: lele
 * Date: 13/07/17
 * Time: 15:45
 */
class TransactionChecker
{

    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function isAllowed($amount){

        if(0 > $amount){

            $provision = $this->em->getRepository('AppBundle:Tirelire')->getTotalAmount();
            return  (0 <= ($provision + $amount));
        }

        return true;
    }
}