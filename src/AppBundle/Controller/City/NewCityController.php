<?php

declare(strict_types=1);

namespace AppBundle\Controller\City;

use AppBundle\Entity\City;
use AppBundle\Exception\RedirectException;
use AppBundle\Form\CityForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewCityController extends AbstractController
{

    /**
     * @param Request $request
     *
     * @return Response
     * @throws RedirectException
     */
    public function __invoke(Request $request): Response
    {
        $city = new City;

        $form = $this->createForm(CityForm::class, $city);

        $this->handleForm($request, $form, $city);

        return $this->render(
            '@App/city/new-city.html.twig',
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

        $manager = $this->getDoctrine()->getManager();

        $manager->persist($city);
        $manager->flush();

        $this->addFlash('success', sprintf('City %s added successfully', $city->getName()));

        throw new RedirectException($this->generateUrl('city_list'));
    }
}
