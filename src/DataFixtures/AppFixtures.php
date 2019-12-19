<?php

namespace App\DataFixtures;

use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $subject = new Subject();
        $subject2 = new Subject();
        $subject3 = new Subject();

        $subject->setName('Bons Plans');
        $manager->persist($subject);

        $subject2->setName('Evénements');
        $manager->persist($subject2);

        $subject3->setName('Articles');
        $manager->persist($subject3);

        $manager->flush();
    }
}
