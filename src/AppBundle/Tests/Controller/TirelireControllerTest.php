<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TirelireControllerTest extends WebTestCase
{

    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /tirelire/");
        $crawler = $client->click($crawler->selectLink('Saisir une operation')->link());

        // Fill in the form with rand value and submit it
        $randAmount = rand(0, 1000);
        $form = $crawler->selectButton('Valider')->form(array(
            'appbundle_tirelire[montant]'  => $randAmount,
            'appbundle_tirelire[date]'  => date('d/m/Y'),
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertSame($randAmount, intval($crawler->filter('#transactions-list tbody tr:last-child .amount')->text()), 'Missing element #transactions-list tbody tr:last-child .amount');

        /*// Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'appbundle_tirelire[field_name]'  => 'Foo',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
         */
    }

}
