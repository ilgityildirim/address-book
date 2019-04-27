<?php

declare(strict_types=1);

namespace AppBundle\Controller\Country;

use AppBundle\Entity\Country;
use AppBundle\Exception\RedirectException;
use AppBundle\Form\CountryForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EditCountryController extends AbstractController
{

    /**
     * @ParamConverter("country", class="AppBundle\Entity\Country")
     *
     * @param Request $request
     * @param Country $country
     *
     * @return Response
     * @throws RedirectException
     */
    public function __invoke(Request $request, Country $country): Response
    {
        if (!$country || !$country->getId() || $country->getDeletedAt()) {
            $this->addFlash('error', 'Country not found!');
            return $this->redirectToRoute('country_list');
        }

        $form = $this->createForm(CountryForm::class, $country);

        $this->handleForm($request, $form, $country);

        return $this->render(
            '@App/country/edit-country.html.twig',
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

        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', sprintf('Country %s saved successfully', $country->getName()));

        throw new RedirectException($this->generateUrl('country_list'));
    }
}
