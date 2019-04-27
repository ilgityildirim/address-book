<?php

declare(strict_types=1);

namespace AppBundle\Controller\Country;

use AppBundle\Entity\City;
use AppBundle\Entity\Country;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;

class CountryCityListController
{
    /**
     * @ParamConverter("country", class="AppBundle\Entity\Country")
     * @param Country $country
     * @return JsonResponse
     */
    public function __invoke(Country $country): JsonResponse
    {
        $data = $country->getCities()
                        ->map(function(City $city) {
                            return [
                                'id' => $city->getId(),
                                'name' => $city->getName(),
                            ];
                        })
                        ->toArray()
        ;

        return new JsonResponse($data);
    }
}
