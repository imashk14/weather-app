<?php

namespace App\Command;

use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:country-and-place',
    description: 'Get weather forecast for a specific location by country code and place name',
)]
readonly class WeatherCountryAndPlaceCommand{
    public function __construct(
        private WeatherUtil $weatherUtil
    ) {
    }
    public function __invoke(
        SymfonyStyle $io,
        #[Argument('The country code of the place you\'re searching for.')] string $countryCode,
        #[Argument('The name of the place you\'re looking for.')] string $placeName,
    ): int {
        $forecasts = $this->weatherUtil->getForecastForCountryAndCity($countryCode, $placeName);
        if (empty($forecasts)) {
            $io->warning(sprintf('No forecasts found for "%s" (%s).', $placeName, $countryCode));
            return Command::FAILURE;
        }

        $io->writeln(sprintf('Location: %s', $forecasts[0]->getLocation()->getName()));
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
