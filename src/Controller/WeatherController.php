<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\ForecastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController
{
    #[Route('/weather/{name},{country}', name: 'app_weather')]
    public function name(Location $location, ForecastRepository $forecastRepository): Response
    {
        $forecasts = $forecastRepository->findByLocation($location);

        return $this->render('weather/name.html.twig', [
            'location' => $location,
            'forecasts' => $forecasts,
        ]);
    }
}
