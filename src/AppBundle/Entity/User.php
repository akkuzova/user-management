<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @UniqueEntity (fields="email", message="Email is already exists")
 * @Serializer\ExclusionPolicy("all")
 */
class User
{
    const ACTIVE = 'active';
    const NON_ACTIVE = 'non-active';

    /**
     * @var int
     *
     * @Serializer\Groups({"list", "details"})
     * @Serializer\Expose
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Serializer\Groups({"list", "details"})
     * @Serializer\Expose
     *
     * @ORM\Column(type="string", length=256, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @Serializer\Groups({"list", "details"})
     * @Serializer\Expose
     *
     * @ORM\Column(type="string", length=256)
     */
    private $firstName;

    /**
     * @var string
     *
     * @Serializer\Groups({"list", "details"})
     * @Serializer\Expose
     *
     * @ORM\Column(type="string", length=256)
     */
    private $lastName;

    /**
     * @var string
     *
     * @Serializer\Groups({"list", "details"})
     * @Serializer\Expose
     *
     * @ORM\Column(type="string")
     */
    private $state;

    /**
     * @var \DateTime
     *
     * @Serializer\Groups({"details"})
     * @Serializer\Expose
     *
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @var Group
     *
     * @Serializer\Groups({"details"})
     * @Serializer\Expose
     *
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="users")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    private $group;

    public function __construct()
    {
        $this->creationDate = new \DateTime();
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
     * @return Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    public function setGroup(Group $group)
    {
        $this->group = $group;
    }
}