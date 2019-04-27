<?php

declare(strict_types=1);

namespace AppBundle\Controller\City;

use AppBundle\Repository\CityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class CityListController
{
    /** @var CityRepository */
    private $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * @param Request $request
     * @param Twig_Environment $twig
     *
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(Request $request, Twig_Environment $twig): Response
    {
        $cities = $this->cityRepository->findBy([
            'deletedAt' => null,
        ]);

        $response = $twig->render(
            '@App/city/index.html.twig',
            [
                'cities' => $cities,
            ]
        );

        return new Response($response);
    }
}
