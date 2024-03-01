<?php

namespace App\DataFixtures;

use App\Entity\Todo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $todo1 = new Todo;
        $todo1->setTitle('Faire un gateau');
        $manager->persist($todo1);

        $todo2 = new Todo;
        $todo2->setTitle('vérifier le code bat C 1962A');
        $manager->persist($todo2);

        $todo3 = new Todo;
        $todo3->setTitle('rdv le 20 à 12h');
        $manager->persist($todo3);


        $manager->flush();
    }
}
