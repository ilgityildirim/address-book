<?php

declare(strict_types=1);

namespace AppBundle\Controller\Country;

use AppBundle\Entity\Country;
use AppBundle\Exception\RedirectException;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;

class DeleteCountryController
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
     * @ParamConverter("country", class="AppBundle\Entity\Country")
     *
     * @param Country|null $country
     *
     * @throws RedirectException
     */
    public function __invoke(Country $country = null)
    {
        if (!$country || !$country->getId() || $country->getDeletedAt()) {
            $this->flashBag->add('error', 'Country not found!');
            throw new RedirectException($this->router->generate('country_list'));
        }

        $this->entityManager->remove($country);
        $this->entityManager->flush();

        $this->flashBag->add('success', sprintf('Country %s has been deleted', $country->getName()));
        throw new RedirectException($this->router->generate('country_list'));
    }
}
