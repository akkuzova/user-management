<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="`group`")
 * @ORM\Entity
 * @UniqueEntity (fields="name", message="Group with this name already exists")
 * @Serializer\ExclusionPolicy("all")
 */
class Group
{
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
    private $name;

    /**
     * @var ArrayCollection
     *
     * @Serializer\Groups({"groupDetails"})
     * @Serializer\Expose
     *
     * @ORM\OneToMany(targetEntity="User", mappedBy="group")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }
}