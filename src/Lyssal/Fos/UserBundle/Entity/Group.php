<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Fos\UserBundle\Entity;

use FOS\UserBundle\Entity\Group as FosUserGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class Group extends FosUserGroup
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * Represents a string representation
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName() ?: '';
    }
}
