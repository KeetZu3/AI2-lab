<?php

namespace App\DataFixtures;

use App\Entity\Miejscowosc;
use App\Entity\DaneMeteorologiczne;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Dodawanie przykładowego użytkownika z rolą ADMIN
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'secure_password')); // hasło użytkownika
        $manager->persist($admin);

        // Dodawanie przykładowego użytkownika z rolą USER
        $user = new User();
        $user->setUsername('user1');
        $user->setRoles(['ROLE_USER']); // Zmieniamy rolę na ROLE_USER
        $user->setPassword($this->passwordHasher->hashPassword($user, 'user1_password')); // hasło użytkownika
        $manager->persist($user);

        $user = new User();
        $user->setUsername('user2');
        $user->setRoles(['ROLE_USER2']); // Zmieniamy rolę na ROLE_USER
        $user->setPassword($this->passwordHasher->hashPassword($user, 'user2_password')); // hasło użytkownika
        $manager->persist($user);

        // Dodawanie danych o miastach i pomiarach
        $szczecin = new Miejscowosc();
        $szczecin->setNazwa('Szczecin');
        $szczecin->setData(new \DateTime());
        $manager->persist($szczecin);

        $daneSzczecin = new DaneMeteorologiczne();
        $daneSzczecin->setLocation($szczecin);
        $daneSzczecin->setTemperaturaWCelsjuszach(10.0);
        $daneSzczecin->setDataPomiaru(new \DateTime());
        $daneSzczecin->setWilgotnosc(80);
        $daneSzczecin->setCisnienie(1013);
        $daneSzczecin->setWiatr(10);
        $manager->persist($daneSzczecin);

        // Dodawanie danych o miastach i pomiarach
        $police = new Miejscowosc();
        $police->setNazwa('Police');
        $police->setData(new \DateTime());
        $manager->persist($police);

        $danePolice = new DaneMeteorologiczne();
        $danePolice->setLocation($police);
        $danePolice->setTemperaturaWCelsjuszach(6.0);
        $danePolice->setDataPomiaru(new \DateTime());
        $danePolice->setWilgotnosc(62);
        $danePolice->setCisnienie(1017);
        $danePolice->setWiatr(16);
        $manager->persist($danePolice);

        $manager->flush();
    }
}
