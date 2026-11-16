<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:location',
    description: 'Get weather forecast for a specific location by ID',
)]
readonly class WeatherLocationCommand{
    public function __construct(
        private LocationRepository $locationRepository,
        private WeatherUtil $weatherUtil
    ) {
    }
    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Location ID')] int $id,
    ): int {
        if ($id <= 0) {
            $io->error('Location ID must be a positive integer.');
            return Command::FAILURE;
        }

        $location = $this->locationRepository->find($id);
        if (!$location) {
            $io->error(sprintf('Location with ID %d not found.', $id));
            return Command::FAILURE;
        }

        $forecasts = $this->weatherUtil->getForecastForLocation($location);

        $io->writeln(sprintf('Location: %s', $location->getName()));
        $io->table(['Date', 'Temperature', 'Overcast', 'Rain', 'Wind'], array_map(fn($f) => [
            $f->getDate()->format('Y-m-d'),
            $f->getTemperature(),
            $f->getOvercast(),
            $f->getRain(),
            $f->getWind(),
            ], $forecasts)
        );

        return Command::SUCCESS;
    }
}
