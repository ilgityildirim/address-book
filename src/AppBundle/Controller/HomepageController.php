<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class HomepageController
{
    /** @var ContactRepository */
    private $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
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
        $contacts = $this->contactRepository->findBy([
            'deletedAt' => null,
        ]);

        $response = $twig->render(
            '@App/homepage/index.html.twig',
            [
                'contacts' => $contacts,
            ]
        );

        return new Response($response);
    }
}
