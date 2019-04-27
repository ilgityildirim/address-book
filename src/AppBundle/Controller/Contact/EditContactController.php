<?php

declare(strict_types=1);

namespace AppBundle\Controller\Contact;

use AppBundle\Entity\Contact;
use AppBundle\Exception\RedirectException;
use AppBundle\Form\ContactForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EditContactController extends AbstractController
{

    /**
     * @ParamConverter("contact", class="AppBundle\Entity\Contact")
     *
     * @param Request $request
     * @param Contact $contact
     *
     * @return Response
     * @throws RedirectException
     */
    public function __invoke(Request $request, Contact $contact): Response
    {
        if (!$contact || !$contact->getId() || $contact->getDeletedAt()) {
            $this->addFlash('error', 'Contact not found!');
            return $this->redirectToRoute('homepage');
        }

        $form = $this->createForm(ContactForm::class, $contact);

        $this->handleForm($request, $form, $contact);

        return $this->render(
            '@App/contact/edit-contact.html.twig',
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

        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', sprintf(
            'Contact %s %s saved successfully',
            $contact->getFirstName(),
            $contact->getLastName()
        ));

        throw new RedirectException($this->generateUrl('homepage'));
    }
}
