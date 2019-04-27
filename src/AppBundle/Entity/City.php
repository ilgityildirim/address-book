<?php

declare(strict_types=1);

namespace AppBundle\Entity;

use Gedmo\SoftDeleteable\Traits\SoftDeleteable;
use Gedmo\Timestampable\Traits\Timestampable;

class City
{
    use Timestampable;
    use SoftDeleteable;

    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var Country */
    private $country;

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return Country|null
     */
    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry(Country $country)
    {
        $this->country = $country;
    }
}
