<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    // Constructeur avec en parametre UserPasswordHasherInterface 
     public function __construct(private UserPasswordHasherInterface $passwordHasher){

    }

    public function load(ObjectManager $manager): void
    {
       
        $admin = new User();
        $admin->setEmail('admin@eval.local');
        $admin->setRoles(['ROLE_ADMIN']);
        // Mettre le mot de passe du fichier pdf pour les tests 
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin,  'XXXXXXXXX') 
        );
        $manager->persist($admin); 

        $manager->flush();
    }
}
