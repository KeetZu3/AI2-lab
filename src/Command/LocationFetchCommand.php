<?php

namespace App\Command;

use App\Service\WeatherUtil;
use App\Repository\MiejscowoscRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LocationFetchCommand extends Command
{
    protected static $defaultName = 'location:fetch';
    protected static $defaultDescription = 'Pobiera prognozę pogody dla wybranej lokalizacji';
    private $weatherUtil;
    private $miejscowoscRepository;

    public function __construct(WeatherUtil $weatherUtil, MiejscowoscRepository $miejscowoscRepository)
    {
        parent::__construct();
        $this->weatherUtil = $weatherUtil;
        $this->miejscowoscRepository = $miejscowoscRepository;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Fetches location information based on city name')
            ->addArgument('cityName', InputArgument::REQUIRED, 'The name of the city');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $cityName = $input->getArgument('cityName');

        // Pobierz lokalizację na podstawie nazwy miasta
        $miejscowosc = $this->miejscowoscRepository->findOneBy(['nazwa' => $cityName]);
        if (!$miejscowosc) {
            $io->error("Lokalizacja $cityName nie istnieje.");
            return Command::FAILURE;
        }

        // Pobierz dane pogodowe dla wybranej lokalizacji
        $weatherData = $this->weatherUtil->getWeatherForLocation($miejscowosc);
        if (empty($weatherData)) {
            $io->warning("Brak danych pogodowych dla lokalizacji: {$cityName}.");
            return Command::SUCCESS;
        }

        // Wyświetl prognozę pogody
        $io->section("Prognoza pogody dla lokalizacji: {$cityName}");
        foreach ($weatherData as $data) {
            $io->listing([
                "Temperatura: {$data->getTemperaturaWCelsjuszach()}°C",
                "Wilgotność: {$data->getWilgotnosc()}%",
                "Ciśnienie: {$data->getCisnienie()} hPa",
                "Wiatr: {$data->getWiatr()} km/h",
                "Data pomiaru: {$data->getDataPomiaru()->format('Y-m-d H:i:s')}",
            ]);
        }

        return Command::SUCCESS;
    }

}
