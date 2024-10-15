<?php

namespace App\DataFixtures;

use App\Entity\Miejscowosc;
use App\Entity\DaneMeteorologiczne;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Dodaj miasto Szczecin
        $szczecin = new Miejscowosc();
        $szczecin->setNazwa('Szczecin');
        $szczecin->setData(new \DateTime());  // ustaw aktualną datę
        $manager->persist($szczecin);

        // Dodaj miasto Police
        $police = new Miejscowosc();
        $police->setNazwa('Police');
        $police->setData(new \DateTime());  // ustaw aktualną datę
        $manager->persist($police);

        // Przykładowe dane meteorologiczne dla Szczecina
        $daneSzczecin = new DaneMeteorologiczne();
        $daneSzczecin->setLocation($szczecin); // Ustaw relację z Miejscowosc
        $daneSzczecin->setTemperaturaWCelsjuszach(15.0);
        $daneSzczecin->setDataPomiaru(new \DateTime());
        $daneSzczecin->setWilgotnosc(80);
        $daneSzczecin->setCisnienie(1013);
        $daneSzczecin->setWiatr(10);
        $manager->persist($daneSzczecin);

        // Przykładowe dane meteorologiczne dla Police
        $danePolice = new DaneMeteorologiczne();
        $danePolice->setLocation($police); // Ustaw relację z Miejscowosc
        $danePolice->setTemperaturaWCelsjuszach(16.5);
        $danePolice->setDataPomiaru(new \DateTime());
        $danePolice->setWilgotnosc(75);
        $danePolice->setCisnienie(1015);
        $danePolice->setWiatr(12);
        $manager->persist($danePolice);

        // Zapisz zmiany do bazy danych
        $manager->flush();
    }
}
