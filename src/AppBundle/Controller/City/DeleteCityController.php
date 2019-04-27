<?php

declare(strict_types=1);

namespace AppBundle\Controller\City;

use AppBundle\Entity\City;
use AppBundle\Exception\RedirectException;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;

class DeleteCityController
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
     * @ParamConverter("city", class="AppBundle\Entity\City")
     *
     * @param City|null $city
     *
     * @throws RedirectException
     */
    public function __invoke(City $city = null)
    {
        if (!$city || !$city->getId() || $city->getDeletedAt()) {
            $this->flashBag->add('error', 'City not found!');
            throw new RedirectException($this->router->generate('city_list'));
        }

        $this->entityManager->remove($city);
        $this->entityManager->flush();

        $this->flashBag->add('success', sprintf('City %s has been deleted', $city->getName()));
        throw new RedirectException($this->router->generate('city_list'));
    }
}
