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
        //ADMINISTRATEUR (accès complet) 
        $admin->setEmail('admin@eval.local');
        $admin->setRoles(['ROLE_ADMIN']);
        // Mettre le mot de passe du fichier pdf pour les tests 
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin,  'pwd-Eval_Admin1') 
        );
        $manager->persist($admin); 

        // PERSONNEL DE L'AGENCE (ROLE_USER) 
        $clientEmails = [
            'user1@eval.local',
            'user2@eval.local',
            'user3@eval.local',
        ];

        foreach ($clientEmails as $email) {
            $client = new User();
            $client->setEmail($email);
            $client->setRoles(['ROLE_USER']); //   utilisateur
            $client->setPassword(
                $this->passwordHasher->hashPassword($client, 'user123')
            );
            $manager->persist($client);
        }
        // Pour les clients ou visiteurs leur adresse mail est dans le ticket

        $manager->flush();
    }
}
