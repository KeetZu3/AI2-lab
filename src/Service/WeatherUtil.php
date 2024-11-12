<?php

namespace App\Service;

use App\Entity\Miejscowosc;
use App\Repository\MiejscowoscRepository;
use App\Repository\DaneMeteorologiczneRepository;

class WeatherUtil
{
    private $miejscowoscRepository;
    private $daneMeteorologiczneRepository;

    public function __construct(MiejscowoscRepository $miejscowoscRepository, DaneMeteorologiczneRepository $daneMeteorologiczneRepository)
    {
        $this->miejscowoscRepository = $miejscowoscRepository;
        $this->daneMeteorologiczneRepository = $daneMeteorologiczneRepository;
    }

    /**
     * Pobiera pomiary dla danej lokalizacji.
     *
     * @param Miejscowosc $miejscowosc
     * @return array
     */
    public function getWeatherForLocation(Miejscowosc $miejscowosc): array
    {
        return $this->daneMeteorologiczneRepository->findBy(['location' => $miejscowosc]);
    }

    /**
     * Pobiera pomiary na podstawie kodu kraju i nazwy miasta.
     *
     * @param string $cityName
     * @return array|null
     */
    public function getWeatherForCountryAndCity(string $cityName): ?array
    {
        $miejscowosc = $this->miejscowoscRepository->findOneBy(['nazwa' => $cityName]);

        if (!$miejscowosc) {
            return null;
        }



        return $this->getWeatherForLocation($miejscowosc);
    }
}
