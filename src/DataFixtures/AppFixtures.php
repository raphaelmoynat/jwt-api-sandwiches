<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Entity\Sandwich;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        $ingredients = ['ham', 'chicken', 'tomatoes', 'salad', 'cheese'];

        foreach ($ingredients as $ingredientName) {
            $ingredient = new Ingredient();
            $ingredient->setName($ingredientName);
            $manager->persist($ingredient);
        }
        $manager->flush();


        $ingredients = $manager->getRepository(Ingredient::class)->findAll();


        for($i = 0; $i < 10; $i++) {
            $sandwich = new Sandwich();
            $sandwich->setName($faker->firstName);
            $sandwich->setPrice($faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10));

            $ingredientsNbr = rand(1,count($ingredients));
            $tempIngredients = $ingredients;

            for ($j = 0; $j < $ingredientsNbr; $j++) {
                $randIndex = array_rand($tempIngredients);
                $ingredient = $tempIngredients[$randIndex];
                unset($tempIngredients[$randIndex]);
                $sandwich->addIngredient($ingredient);
            }
            $manager->persist($sandwich);

        }
        $manager->flush();

    }
}
