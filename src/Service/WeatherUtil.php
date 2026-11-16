<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\Forecast;
use App\Repository\LocationRepository;

class WeatherUtil
{
    public function __construct(
        private readonly LocationRepository $locationRepository,
    ) {
    }

    /**
    * @return Forecast[]
    */
    public function getForecastForLocation(Location $location) : array
    {
        return $location->getForecasts()->toArray();
    }

    /**
     * @return Forecast[]
     */
    public function getForecastForCountryAndCity(string $countryCode, string $city) : array
    {
        $location = $this->locationRepository->findOneByCountryAndCity($countryCode, $city);
        if ($location === null) {
            return [];
        }

        return $this->getForecastForLocation($location);
    }
}
