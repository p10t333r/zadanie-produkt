<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase {

    public function testIndex() {

        //check if admin page is blocked for not logged users
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        //check login with bad credentials
        $client = static::createClient(array(), array(
                    'PHP_AUTH_USER' => 'bad',
                    'PHP_AUTH_PW' => 'cred',
        ));
        $crawler = $client->request('GET', '/admin');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());


        //check login with correct credentials
        $client = static::createClient(array(), array(
                    'PHP_AUTH_USER' => 'admin',
                    'PHP_AUTH_PW' => '123',
        ));
        $crawler = $client->request('GET', '/admin');
        $this->assertContains('Witaj administratorze!', $crawler->filter('.container h1')->text());
    }

    public function testNewProduct() {
        $client = static::createClient(array(), array(
                    'PHP_AUTH_USER' => 'admin',
                    'PHP_AUTH_PW' => '123',
        ));

        //check if path correct
        $crawler = $client->request('GET', '/admin/new-product');
        $this->assertContains('Dodaj produkt!', $crawler->filter('.container h1')->text());

        //test submit empty form
        $form = $crawler->selectButton('product[Zapisz]')->form();
        $crawler = $client->submit($form);
        $errors = $crawler->filter('.form-group.has-error .help-block');
        $this->assertEquals(3, $errors->count());

        //test submit description shorter than required
        $form = $crawler->selectButton('product[Zapisz]')->form();
        $form->setValues(array(
            'product[name]' => 'Product',
            'product[description]' => 'To shord desc',
            'product[price]' => '22,20'
        ));
        $crawler = $client->submit($form);
        $descriptionErrorMessage = trim($crawler->filter('[name="product[description]"] ~ span')->text());
        $this->assertEquals('Opis powinien zawierać co namniej 100 znaków', $descriptionErrorMessage);

        //test submit with wrong price data
        $form = $crawler->selectButton('product[Zapisz]')->form();
        $form->setValues(array(
            'product[name]' => 'Product',
            'product[description]' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse id mauris ullamcorper volutpat.',
            'product[price]' => 'wrongData'
        ));
        $crawler = $client->submit($form);
        $priceErrorMessage = trim($crawler->filter('.help-block')->text());
        $this->assertEquals('Ta wartość jest nieprawidłowa.', $priceErrorMessage);

        //test submit with correct data
        $form = $crawler->selectButton('product[Zapisz]')->form();
        $form->setValues(array(
            'product[name]' => 'Product',
            'product[description]' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse id mauris ullamcorper volutpat.',
            'product[price]' => '27,90'
        ));
        $client->enableProfiler();
        $crawler = $client->submit($form);
        
        //test email send
        $mailCollector = $client->getProfile()->getCollector('swiftmailer');
        $this->assertEquals(1, $mailCollector->getMessageCount());
        
        //test add product
        $client->followRedirect();
        $response = $client->getResponse();
        $this->assertContains('Produkt został dodany!', $response->getContent());

    }

}
