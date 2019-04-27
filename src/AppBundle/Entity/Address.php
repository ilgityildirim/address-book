<?php

declare(strict_types=1);

namespace AppBundle\Entity;

use Gedmo\SoftDeleteable\Traits\SoftDeleteable;
use Gedmo\Timestampable\Traits\Timestampable;

class Address
{
    use Timestampable;
    use SoftDeleteable;

    /** @var string */
    private $id;

    /** @var Contact */
    private $contact;

    /** @var Country */
    private $country;

    /** @var City */
    private $city;

    /** @var string */
    private $title;

    /** @var string */
    private $streetLine1;

    /** @var string */
    private $streetLine2;

    /** @var string */
    private $phoneNumber;

    public function getId(): string
    {
        return $this->id;
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }

    public function setContact(Contact $contact)
    {
        $this->contact = $contact;
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

    /**
     * @return City|null
     */
    public function getCity()
    {
        return $this->city;
    }

    public function setCity(City $city)
    {
        $this->city = $city;
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getStreetLine1()
    {
        return $this->streetLine1;
    }

    public function setStreetLine1(string $streetLine1)
    {
        $this->streetLine1 = $streetLine1;
    }

    /**
     * @return string|null
     */
    public function getStreetLine2()
    {
        return $this->streetLine2;
    }

    /**
     * @param string|null $streetLine2
     */
    public function setStreetLine2($streetLine2)
    {
        $this->streetLine2 = $streetLine2;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string|null $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber = null)
    {
        $this->phoneNumber = $phoneNumber;
    }
}
