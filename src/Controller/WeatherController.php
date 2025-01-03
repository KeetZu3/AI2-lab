<?php

namespace App\Controller;

use App\Repository\DaneMeteorologiczneRepository;
use App\Repository\MiejscowoscRepository;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{nazwa}', name: 'app_weather')]
    public function city(string $nazwa, MiejscowoscRepository $miejscowoscRepository, WeatherUtil $util): Response
    {

        $miejscowosc = $miejscowoscRepository->findOneBy(['nazwa' => $nazwa]);


        if (!$miejscowosc) {
            throw $this->createNotFoundException('Miejscowość nie została znaleziona.');
        }


        $daneMeteorologiczne = $util->getWeatherForLocation($miejscowosc);


        return $this->render('weather/city.html.twig', [
            'miejscowosc' => $miejscowosc,
            'daneMeteorologiczne' => $daneMeteorologiczne,
        ]);
    }
}
