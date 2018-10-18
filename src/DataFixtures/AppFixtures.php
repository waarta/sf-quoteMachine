<?php

namespace App\DataFixtures;

use App\Entity\Quote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create("fr_FR");
        $quote1 = new Quote();
        $quote1->setContent("Sire, Sire !!! On en a gros !");
        $quote1->setMeta("Perceval, Livre II, Les Exploit\u00e9s");

        $quote2 = new Quote();
        $quote2->setContent("[Dame S\u00e9li : Les tartes, la p\u00eache, tout \u00e7a c'est du patrimoine] (Arthur, montrant la tarte) C'est du patrimoine \u00e7a ?\n");
        $quote2->setMeta("Arthur, Livre I, La tarte aux myrtilles");

        $manager->persist($quote1);
        $manager->persist($quote2);

        // create 10 quotes random
        for ($i = 0; $i < 10; $i++) {
            $quote3 = new Quote();
            $quote3->setContent($faker->text);
            $quote3->setMeta($faker->name);
            $manager->persist($quote3);
        }

        $manager->flush();

    }
}
