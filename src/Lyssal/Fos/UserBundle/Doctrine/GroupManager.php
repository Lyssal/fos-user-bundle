<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Fos\UserBundle\Doctrine;

use FOS\UserBundle\Doctrine\GroupManager as FosGroupManager;

/**
 * An extension of the FOS User group manager.
 */
class GroupManager extends FosGroupManager
{
    /**
     * Get the names of the user groups keyed by ID.
     *
     * @return string[int] The names keyed by ID
     */
    public function getNamesKeyedById()
    {
        $namesById = array();

        foreach ($this->findGroups() as $group) {
            $namesById[$group->getId()] = $group->getName();
        }

        return $namesById;
    }
}
