<?php

declare(strict_types=1);

namespace AppBundle\Controller\Contact;

use AppBundle\Entity\Contact;
use AppBundle\Exception\RedirectException;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;

class DeleteContactController
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var RouterInterface */
    private $router;

    /** @var FlashBagInterface */
    private $flashBag;

    public function __construct(
        EntityManagerInterface $entityManager,
        RouterInterface $router,
        FlashBagInterface $flashBag
    ) {
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
        $this->router = $router;
    }

    /**
     * @ParamConverter("contact", class="AppBundle\Entity\Contact")
     *
     * @param Contact|null $contact
     *
     * @throws RedirectException
     */
    public function __invoke(Contact $contact = null)
    {
        if (!$contact || !$contact->getId() || $contact->getDeletedAt()) {
            $this->flashBag->add('error', 'Contact not found!');
            throw new RedirectException($this->router->generate('homepage'));
        }

        $this->entityManager->remove($contact);
        $this->entityManager->flush();

        $this->flashBag->add('success', sprintf(
            'Contact %s %s has been deleted',
            $contact->getFirstName(),
            $contact->getLastName()
        ));

        throw new RedirectException($this->router->generate('homepage'));
    }
}
