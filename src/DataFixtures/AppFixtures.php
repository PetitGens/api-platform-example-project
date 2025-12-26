<?php

namespace App\DataFixtures;

use App\Tests\Factory\AuthorFactory;
use App\Tests\Factory\BookFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        AuthorFactory::createMany(2);
        BookFactory::createMany(10);

        $manager->flush();
    }
}
