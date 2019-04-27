<?php

declare(strict_types=1);

namespace AppBundle\Controller\Country;

use AppBundle\Entity\Country;
use AppBundle\Exception\RedirectException;
use AppBundle\Form\CountryForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewCountryController extends AbstractController
{

    /**
     * @param Request $request
     *
     * @return Response
     * @throws RedirectException
     */
    public function __invoke(Request $request): Response
    {
        $country = new Country;

        $form = $this->createForm(CountryForm::class, $country);

        $this->handleForm($request, $form, $country);

        return $this->render(
            '@App/country/new-country.html.twig',
            [
                'country' => $country,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @param Request $request
     * @param FormInterface $form
     * @param Country $country
     *
     * @throws RedirectException
     */
    private function handleForm(Request $request, FormInterface $form, Country $country)
    {
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return;
        }

        $manager = $this->getDoctrine()->getManager();

        $manager->persist($country);
        $manager->flush();

        $this->addFlash('success', sprintf('Country %s added successfully', $country->getName()));

        throw new RedirectException($this->generateUrl('country_list'));
    }
}
