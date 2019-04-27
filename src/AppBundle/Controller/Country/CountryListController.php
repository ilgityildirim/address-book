<?php

declare(strict_types=1);

namespace AppBundle\Controller\Country;

use AppBundle\Repository\CountryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class CountryListController
{
    /** @var CountryRepository */
    private $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
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
        $countries = $this->countryRepository->findBy([
            'deletedAt' => null,
        ]);

        $response = $twig->render(
            '@App/country/index.html.twig',
            [
                'countries' => $countries,
            ]
        );

        return new Response($response);
    }
}
