<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Fos\UserBundle\Entity;

use FOS\UserBundle\Entity\User as FosUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 * @ORM\HasLifecycleCallbacks()
 */
abstract class User extends FosUser
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updated;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="Group", cascade={"persist"})
     * @ORM\JoinTable(name="user_user_group", joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")}, inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="CASCADE")})
     */
    protected $groups;


    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the creation date
     *
     * @param \DateTime|null $created
     */
    public function setCreated(\DateTime $created = null)
    {
        $this->created = $created;
    }

    /**
     * Returns the creation date
     *
     * @return \DateTime|null
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Sets the last update date
     *
     * @param \DateTime|null $updatedAt
     */
    public function setUpdated(\DateTime $updated = null)
    {
        $this->updated = $updated;
    }

    /**
     * Returns the last update date
     *
     * @return \DateTime|null
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @return array
     */
    public function getRealRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRealRoles(array $roles)
    {
        $this->setRoles($roles);
    }


    /**
     * Hook on pre-persist operations
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->created = new \DateTime();
    }

    /**
     * Hook on pre-update operations
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function preUpdate()
    {
        $this->updated = new \DateTime();
    }

    /**
     * Returns a string representation
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getUsername() ?: '-';
    }
}
