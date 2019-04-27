<?php

declare(strict_types=1);

namespace AppBundle\Controller\Contact;

use AppBundle\Entity\Contact;
use AppBundle\Exception\RedirectException;
use AppBundle\Form\ContactForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

class NewContactController extends AbstractController
{
    /**
     * @param Request $request
     * @param Twig_Environment $twig
     *
     * @return Response
     * @throws RedirectException
     */
    public function __invoke(Request $request, Twig_Environment $twig): Response
    {
        $contact = new Contact;

        $form = $this->createForm(ContactForm::class, $contact);

        $this->handleForm($request, $form, $contact);

        return $this->render(
            '@App/contact/new-contact.html.twig',
            [
                'contact' => $contact,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @param Request $request
     * @param FormInterface $form
     * @param Contact $contact
     *
     * @throws RedirectException
     */
    private function handleForm(Request $request, FormInterface $form, Contact $contact)
    {
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return;
        }

        $manager = $this->getDoctrine()->getManager();

        $manager->persist($contact);
        $manager->flush();

        $this->addFlash('success', sprintf(
            'Contact %s %s added successfully',
            $contact->getFirstName(),
            $contact->getLastName()
        ));

        throw new RedirectException($this->generateUrl('homepage'));
    }
}
