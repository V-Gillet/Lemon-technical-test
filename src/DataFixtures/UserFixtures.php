<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private const LOOP_INDEX = 20;
    private const SEXE_CHOICES = ['Homme', 'Femme', 'Autre'];
    private const OCCUPATION_CHOICES = ['Cadre', 'Employé de la fonction publique', 'Profession libérale'];

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {

        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();


        for ($i = 0; $i < self::LOOP_INDEX; $i++) {
            $user = new User();
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setEmail($faker->email());
            $user->setPassword($faker->password());
            $user->setCountry($faker->countryCode());
            $user->setSexe(self::SEXE_CHOICES[rand(0, 2)]);
            $user->setOccupation(self::OCCUPATION_CHOICES[rand(0, 2)]);

            $manager->persist($user);
        }

        // user with the role user
        $user = new User();

        $user->setEmail('user@mail.com');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'user000'
        );
        $user->setPassword($hashedPassword);
        $user->setFirstname('John');
        $user->setLastname('Doe');
        $user->setCountry($faker->countryCode());
        $user->setSexe(self::SEXE_CHOICES[rand(0, 2)]);
        $user->setOccupation(self::OCCUPATION_CHOICES[rand(0, 2)]);
        $manager->persist($user);


        // user with the role admin
        $admin = new User();

        $admin->setEmail('admin@mail.com');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'admin000'
        );
        $admin->setPassword($hashedPassword);
        $admin->setFirstname('Jane');
        $admin->setLastname('Doe');
        $admin->setCountry($faker->countryCode());
        $admin->setSexe(self::SEXE_CHOICES[rand(0, 2)]);
        $admin->setOccupation(self::OCCUPATION_CHOICES[rand(0, 2)]);
        $admin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);

        $manager->flush();
    }
}
