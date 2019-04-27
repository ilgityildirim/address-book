<?php

declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable;
use Gedmo\Timestampable\Traits\Timestampable;

class Country
{
    use Timestampable;
    use SoftDeleteable;

    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $code;

    /** @var Collection */
    private $cities;

    public function __construct()
    {
        $this->cities = new ArrayCollection;
    }

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
     * @return string|null
     */
    public function getCode()
    {
        return $this->code;
    }

    public function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return Collection|City[]
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    /**
     * @param Collection|City[] $cities
     */
    public function setCities(Collection $cities)
    {
        $this->cities = $cities;
    }

    public function addCity(City $city)
    {
        if ($this->cities->contains($city)) {
            return;
        }

        $this->cities->add($city);
        $city->setCountry($this);
    }

    public function removeCity(City $city)
    {
        if (!$this->cities->contains($city)) {
            return;
        }

        $this->cities->removeElement($city);
    }
}
