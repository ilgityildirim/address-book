<?php

declare(strict_types=1);

namespace AppBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable;
use Gedmo\Timestampable\Traits\Timestampable;

class Contact
{
    use Timestampable;
    use SoftDeleteable;

    /** @var string */
    private $id;

    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    /** @var string */
    private $email;

    /** @var DateTime */
    private $birthday;

    /** @var Collection */
    private $addresses;

    public function __construct()
    {
        $this->addresses = new ArrayCollection;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return DateTime|null
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param DateTime|null $birthday
     */
    public function setBirthday($birthday = null)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return Collection|Address[]
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    /**
     * @param Collection|Address[] $addresses
     */
    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
    }

    /**
     * @param Address $address
     * @return void
     */
    public function addAddress(Address $address)
    {
        if ($this->addresses->contains($address)) {
            return;
        }

        $this->addresses->add($address);
        $address->setContact($this);
    }

    /**
     * @param Address $address
     * @return void
     */
    public function removeAddress(Address $address)
    {
        if (!$this->addresses->contains($address)) {
            return;
        }

        $this->addresses->removeElement($address);
    }

    /**
     * @return string|null
     */
    public function getFullName()
    {
        $fullName = $this->getFirstName() . ' ' . $this->getLastName();
        return strlen($fullName) > 1 ? $fullName : null;
    }
}
