<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuoteControllerTest extends WebTestCase
{
    public function testLoginUser()
    {
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request('GET', 'login/');

        $buttonCrawlerNode = $crawler->selectButton('Sign in');
        $form = $buttonCrawlerNode->form(array(
            'username' => 'test',
            'password' => 'test',
        ));

        $crawler = $client->submit($form);
        $this->assertContains(
            'se déconnecter',
            $client->getResponse()->getContent());
    }
    public function testQuotes()
    {
        $client = static::createClient();
        $client->request('GET', 'quotes/');
        $this->assertContains(
            'Quotes',
            $client->getResponse()->getContent());
    }

    /*public function testAdd()
    {
    $client = static::createClient();
    $client->followRedirects();
    $crawler = $client->request('GET', 'quotes/');

    $buttonCrawlerNode = $crawler->selectButton('Save');
    $form = $buttonCrawlerNode->form(array(
    'quote[content]' => 'quote 1',
    'quote[meta]' => 'quote 1',
    ));

    $crawler = $client->submit($form);
    $this->assertEquals(1, $crawler->filter("li")->count());
    $this->assertContains(
    'quote 1',
    $client->getResponse()->getContent());
    }*/
/*
public function testModify()
{
$client = static::createClient();
$client->followRedirects();
$crawler = $client->request('GET', 'quotes/');

$link = $crawler->selectLink('Modifier')->link();
$crawler = $client->click($link);

$buttonCrawlerNode = $crawler->selectButton('Save');
$form = $buttonCrawlerNode->form(array(
'quote[content]' => 'quote 1555',
'quote[meta]' => 'quote 1555',
));

$crawler = $client->submit($form);
$this->assertContains(
'quote 1555',
$client->getResponse()->getContent());
}

public function testSupprimer()
{
$client = static::createClient();
$client->followRedirects();
$crawler = $client->request('GET', 'quotes/');
$this->assertEquals(1, $crawler->filter("li")->count());

$link = $crawler->selectLink('Supprimer')->link();
$crawler = $client->click($link);

$this->assertEquals(0, $crawler->filter("li")->count());
}
 */
}
