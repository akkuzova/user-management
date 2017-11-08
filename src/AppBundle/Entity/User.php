<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
{
    const ACTIVE = 'active';
    const NON_ACTIVE = 'non-active';

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\Email
     *
     * @ORM\Column(type="string", length=256)
     */
    private $email;

    /**
     * @var string
     *
     * @Assert\NotBlank
     *
     * @ORM\Column(type="string", length=256)
     */
    private $firstName;

    /**
     * @var string
     *
     * @Assert\NotBlank
     *
     * @ORM\Column(type="string", length=256)
     */
    private $lastName;

    /**
     * @var string
     *
     * @Assert\NotBlank
     *
     * @ORM\Column(type="string", nullable=false, options={"default":"active"})
     */
    private $state;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEnti ty="Group", inversedBy="users")
     * @ORM\JoinTable(name="users_groups")
     */
    private $groups;

    public function __construct()
    {
        $this->creationDate = new \DateTime();
        $this->groups = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param string $creationDate
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return ArrayCollection
     */
    public function getGroups()
    {
        return $this->groups;
    }
}