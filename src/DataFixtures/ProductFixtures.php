<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 1; $i <= 11; $i++) {
            $product = new Product();
            $product->setName($faker->word());
            $product->setPrice($faker->randomFloat(2, 1, 1000));

            $manager->persist($product);
        }

        $manager->flush();
    }
}