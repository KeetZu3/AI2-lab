<?php

namespace App\Controller;

use App\Service\WeatherUtil;
use App\Entity\DaneMeteorologiczne;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WeatherApiController extends AbstractController
{
    private $weatherUtil;

    public function __construct(WeatherUtil $weatherUtil)
    {
        $this->weatherUtil = $weatherUtil;
    }

    #[Route('/api/v1/weather', name: 'app_weather_api', methods: ['GET'])]
    public function getWeather(#[MapQueryParameter] ?string      $city,
                               #[MapQueryParameter] ?string      $format = 'json',
                               #[MapQueryParameter('twig')] bool $twig = false): Response
    {


        if (!$city) {
            return $this->json(['error' => 'City parameter is required.'], Response::HTTP_BAD_REQUEST);
        }

        // Fetch weather data using WeatherUtil
        $weatherData = $this->weatherUtil->getWeatherForCountryAndCity($city);

        if (!$weatherData) {
            return $this->json(['error' => "No weather data found for city: $city."], Response::HTTP_NOT_FOUND);
        }

        // Obsługa formatu CSV z TWIG
        if ($format === 'csv') {
            if ($twig) {
                // Renderowanie z wykorzystaniem TWIG (plik CSV w formacie TWIG)
                return $this->render('weather_api/index.csv.twig', [
                    'city' => $city,
                    'weatherData' => $weatherData,
                ]);
            }

            $csvHeader = "City,TemperatureCelsius,Fahrenheit,Humidity,Pressure,Wind,Measurement Date\n";
            $csvRows = array_map(fn($weatherData) => sprintf(
                "%s,%s,%s,%s,%s,%s,%s",
                $city,
                $weatherData->getTemperaturaWCelsjuszach(),
                $weatherData->getFahrenheit(),
                $weatherData->getWilgotnosc(),
                $weatherData->getCisnienie(),
                $weatherData->getWiatr(),
                $weatherData->getDataPomiaru()->format('Y-m-d H:i:s')

            ), $weatherData);
            $csvOutput = $csvHeader . implode("\n", $csvRows);

            return new Response($csvOutput, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'inline; filename="weather.csv"',
            ]);
        }

        // Obsługa formatu JSON z TWIG
        if ($format === 'json') {
            if ($twig) {
                // Renderowanie odpowiedzi w formacie JSON przy użyciu TWIG
                return $this->render('weather_api/index.json.twig', [
                    'city' => $city,
                    'weatherData' => $weatherData,
                ]);
            }

            // Generowanie odpowiedzi w formacie JSON (domyślnie)
            return new JsonResponse([
                'city' => $city,
                'data' => array_map(function ($data) {
                    return [
                        'temperatureCelsius' => $data->getTemperaturaWCelsjuszach(),
                        'temperatureFahrenheit' =>$data->getFahrenheit(),
                        'humidity' => $data->getWilgotnosc(),
                        'pressure' => $data->getCisnienie(),
                        'wind' => $data->getWiatr(),
                        'measurement_date' => $data->getDataPomiaru()->format('Y-m-d H:i:s'),
                    ];
                }, $weatherData)
            ]);
        }

        // Domyślnie zwracamy odpowiedź w JSON, jeśli format nie jest określony
        return new JsonResponse(['error' => 'Unsupported format.'], Response::HTTP_BAD_REQUEST);
    }
}


