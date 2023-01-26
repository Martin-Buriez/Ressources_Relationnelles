<?php

namespace App\DataFixtures;

use App\Entity\Publication;
use App\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($a = 0; $a < 10; $a++) {
            $theme = new Theme();
            $theme->setName($faker->sentence(1, false));

            $manager->persist($theme);

            for($b = 0; $b < mt_rand(1,3); $b++) {
                $publication = new Publication();
                $publication->setTitle($faker->sentence(1))
                    ->setDescription($faker->sentence(10))
                    ->setLikeNumber($faker->randomNumber(1))
                    ->setSharingNumber($faker->randomNumber(1))
                    ->setViewNumber($faker->randomNumber(1))
                    ->setStatePrivate($faker->boolean(50))
                    ->setStateValidated($faker->boolean(50))
                    ->setCreatedAt($faker->dateTime())
                    ->setTheme($theme);

                $manager->persist($publication);
            }
        }

        $manager->flush();
    }
}
