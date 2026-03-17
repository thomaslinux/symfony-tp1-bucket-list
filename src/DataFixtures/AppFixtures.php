<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture //implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $this->addCategories($manager);
        $this->addWishes($manager);
    }

    public function addCategories(ObjectManager $manager)
    {

        $categories = ['Travel & Adventure', 'Sport', 'Entertainment', 'Human relations', 'Others'];

        foreach ($categories as $cate) {

            $category = new Category();
            $category->setName($cate);

            $manager->persist($category);
        }

        $manager->flush();

    }

    public function addWishes(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $categories = $manager->getRepository(Category::class)->findAll();

        for ($i = 0; $i < 50; $i++) {
            $wish = new Wish();
            $wish->setTitle($faker->text(15))
                ->setDateCreated($faker->dateTimeBetween('-6 year'))
                ->setDescription($faker->sentence())
                ->setCategory($faker->randomElement($categories))
                ->setIsPublished($faker->boolean(70));

            $manager->persist($wish);
        }
        $manager->flush();

    }

//    public function getDependencies(): array
//    {
//        // TODO: Implement getDependencies() method.
//    }
}
