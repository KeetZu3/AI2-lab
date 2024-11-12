<?php

namespace App\Command;

use App\Service\WeatherUtil;
use App\Repository\MiejscowoscRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class WeatherMiejscowoscCommand extends Command
{
    protected static $defaultName = 'weather:location';
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
            ->addArgument('locationId', InputArgument::REQUIRED, 'ID lokalizacji, dla której chcesz pobrać prognozę pogody');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $locationId = $input->getArgument('locationId');

        // Pobierz lokalizację na podstawie ID
        $miejscowosc = $this->miejscowoscRepository->find($locationId);
        if (!$miejscowosc) {
            $io->error("Lokalizacja o ID $locationId nie istnieje.");
            return Command::FAILURE;
        }

        // Pobierz prognozę pogody dla lokalizacji
        $weatherData = $this->weatherUtil->getWeatherForLocation($miejscowosc);

        if (empty($weatherData)) {
            $io->warning("Brak danych pogodowych dla lokalizacji: {$miejscowosc->getNazwa()}.");
            return Command::SUCCESS;
        }

        // Wyświetl prognozę pogody
        $io->section("Prognoza pogody dla lokalizacji: {$miejscowosc->getNazwa()}");
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
