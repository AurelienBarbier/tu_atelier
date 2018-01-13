<?php
/**
 * Created by PhpStorm.
 * User: lele
 * Date: 13/07/17
 * Time: 16:50
 */

namespace Tests\AppBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlSuccessProvider
     */
    public function testPageIsSuccessful($url)
    {

        $client = self::createClient();
        $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlSuccessProvider()
    {
        return array(
            array('/'),
            array('/new'),
            array('/2')
        );
    }


    /**
     * @dataProvider urlFailProvider
     */
    public function testPageFail($url)
    {

        $client = self::createClient();
        $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isNotFound());
    }

    public function urlFailProvider()
    {
        return array(
            array('/200000'),
            array('/2/edit'),
        );
    }
}