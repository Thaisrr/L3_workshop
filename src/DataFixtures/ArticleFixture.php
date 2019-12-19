<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Article;
use App\Entity\Subject;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;

class ArticleFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /**

        $user = new User();
        $user->setLastname('Martin')->setFirstname('Micheline');
        $user->setEmail('user@mail.fr')->setPassword('$argon2id$v=19$m=65536,t=4,p=1$/sLzznMeq1zcG06FgCkxpQ$dm5uTJZjnVJI/CF16InhIejE9KpDXFoDJn1n5myT7K0');
        $address = new Address();
        $address->setCity('Lille')->setCountry('France')->setNumber(6)->setStreet('Rue des oiseaux')->setUser($user);

         $article = new Article();
         $article->setText('Lorem ipsum quelque chose, un très bon article, plein de trucs à dire.');
         $article->setTitle('Mon article !');

         $subject = new Subject();
         $subject->setName('Article');


         $manager->persist($article);

         $article->setAuthor($user);
         $article->setSubject($subject);

        $manager->flush();
         **/
    }
}
