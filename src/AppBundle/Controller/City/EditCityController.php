<?php

declare(strict_types=1);

namespace AppBundle\Controller\City;

use AppBundle\Entity\City;
use AppBundle\Exception\RedirectException;
use AppBundle\Form\CityForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EditCityController extends AbstractController
{

    /**
     * @ParamConverter("city", class="AppBundle\Entity\City")
     *
     * @param Request $request
     * @param City $city
     *
     * @return Response
     * @throws RedirectException
     */
    public function __invoke(Request $request, City $city): Response
    {
        if (!$city || !$city->getId() || $city->getDeletedAt()) {
            $this->addFlash('error', 'City not found!');
            return $this->redirectToRoute('city_list');
        }

        $form = $this->createForm(CityForm::class, $city);

        $this->handleForm($request, $form, $city);

        return $this->render(
            '@App/city/edit-city.html.twig',
            [
                'city' => $city,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @param Request $request
     * @param FormInterface $form
     * @param City $city
     *
     * @throws RedirectException
     */
    private function handleForm(Request $request, FormInterface $form, City $city)
    {
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return;
        }

        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', sprintf('City %s saved successfully', $city->getName()));

        throw new RedirectException($this->generateUrl('city_list'));
    }
}
