<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function addWishes(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $categories = $manager->getRepository(Category::class);
        for ($i = 0; $i < 50; $i++) {
            $wish = new Wish();
            $wish
                ->setTitle($faker->text(15))
                ->setAuthor($faker->userName())
                ->setDateCreated($faker->dateTime())
                ->setDescription($faker->sentence())
                ->setCategory($faker->randomElement($categories))
                ->setIsPublished($faker->boolean(70));

            $manager->persist($wish);
        }
        $manager->flush($wish);
    }

    public function addCategories(ObjectManager $manager)
    {
        $categories = ['Traval & Adventure', 'Sport', 'Entertainment', 'Human relations', 'Others'];
        foreach ($categories as $cate) {
            $category = new Category();
            $category->setName($cate);

            $manager->persist($category);
        }
        $manager->flush();
    }

    public function load(ObjectManager $manager): void
    {
        $this->addCategories();
        $this->addWishes();
    }
}
