<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Publication;
use App\Entity\PublicationIncludeImage;
use App\Entity\Theme;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($c = 0; $c < 5; $c++) {

            // Creation of 5 Themes

            $theme = new Theme();
            $theme->setName($faker->sentence(1, false));

            $manager->persist($theme);

            // Creation of 5 Categories

            $category = new Category();
            $category->setTitle($faker->sentence(1,false));

            $manager->persist($category);

            for($a = 0; $a < mt_rand(0, 2); $a++) {

                // After creating a Theme, we will create between 0 and 2 Users

                $user = new User();
                $user->setEmail($faker->email())
                    ->setPassword("password")
                    ->setUsername($faker->sentence(1))
                    ->setFirstName($faker->firstName())
                    ->setLastName($faker->lastName())
                    ->setAddress($faker->address())
                    ->setPostalCode($faker->postcode())
                    ->setCity($faker->city())
                    ->setPhoneNumber($faker->phoneNumber())
                    ->setBirthday(($faker->dateTime()))
                    ->setCreatedAt(($faker->dateTime()))
                    ->setStateValidated($faker->boolean(50))
                    ->setStateSuspended($faker->boolean(50))
                    ->setIdentityCardLocation($faker->sentence(1))
                    ->setIdentityCardValidated($faker->boolean(50))
                    ->setProfilePicture($faker->sentence(1));

                $manager->persist($user);

                // Each User own between 0 and 4 publications

                for ($b = 0; $b < mt_rand(0, 4); $b++) {
                    $publication = new Publication();
                    $publication->setTitle($faker->sentence(1))
                        ->setDescription($faker->sentence(10))
                        ->setLikeNumber($faker->randomNumber(1))
                        ->setSharingNumber($faker->randomNumber(1))
                        ->setViewNumber($faker->randomNumber(1))
                        ->setStatePrivate($faker->boolean(50))
                        ->setStateValidated($faker->boolean(50))
                        ->setCreatedAt($faker->dateTime())
                        ->setCreatedBy($user)
                        ->setTheme($theme)
                        ->setCategory($category);

                    $manager->persist($publication);

                    // Creation of the Image

                    $imageId = $faker->numberBetween(0,7);

                    $image = new Image();
                    $image->setName("fixture" . $imageId . ".jpg");

                    $manager->persist($image);

                    // Add image to the publication

                    $imageForPublication = new PublicationIncludeImage();
                    $imageForPublication->setPublication($publication)
                        ->setImage($image);

                    $manager->persist($imageForPublication);

                }
            }
        }

        $manager->flush();

    }



}
