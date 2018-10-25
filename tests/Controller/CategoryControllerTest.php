<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testCategory()
    {
        $client = static::createClient();
        $client->request('GET', 'category/');
        $this->assertContains(
            'Categories',
            $client->getResponse()->getContent());
    }

    public function testAdd()
    {
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request('GET', 'category/');

        $buttonCrawlerNode = $crawler->selectButton('Save');
        $form = $buttonCrawlerNode->form(array(
            'category[libCatg]' => 'categ 1',
        ));

        $crawler = $client->submit($form);

        $this->assertContains(
            'categ 1',
            $client->getResponse()->getContent());
    }

    public function testModify()
    {
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request('GET', 'category/');

        $link = $crawler->selectLink('Modifier')->link();
        $crawler = $client->click($link);

        $buttonCrawlerNode = $crawler->selectButton('Save');
        $form = $buttonCrawlerNode->form(array(
            'category[libCatg]' => 'categ 155',
        ));

        $crawler = $client->submit($form);

        $this->assertContains(
            'categ 155',
            $client->getResponse()->getContent());
    }

    public function testSupprimer()
    {
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request('GET', 'category/');
        $this->assertEquals(1, $crawler->filter("li")->count());

        $link = $crawler->selectLink('Supprimer')->link();
        $crawler = $client->click($link);

        $this->assertEquals(0, $crawler->filter("li")->count());
    }

}
