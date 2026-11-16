<?php

namespace App\Controller;

use App\Entity\Location;
use App\Service\WeatherUtil;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController
{
    #[Route('/{countryCode}/{city}', name: 'app_weather', requirements: ['countryCode' => '[A-Z]{2}'])]
    public function name(
        #[MapEntity(mapping: ['countryCode' => 'country', 'city' => 'name'])]
        Location $location,
        WeatherUtil $util
    ): Response
    {
        $forecasts = $util->getForecastForLocation($location);

        return $this->render('weather/name.html.twig', [
            'location' => $location,
            'forecasts' => $forecasts,
        ]);
    }
}
