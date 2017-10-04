<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Fos\UserBundle\Doctrine;

use FOS\UserBundle\Doctrine\UserManager as FosUserManager;

/**
 * An extension of the FOS User manager.
 */
class UserManager extends FosUserManager
{
    /**
     * {@inheritDoc}
     */
    public function findUsersBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Update the enabled properties of users.
     *
     * @param \Lyssal\Fos\UserBundle\Entity\User[] $users   The users
     * @param bool                                 $enabled The enabled
     */
    public function updateEnabledByUsers($users, $enabled)
    {
        foreach ($users as $user) {
            $user->setEnabled($enabled);
            $this->updateUser($user, false);
        }

        $this->objectManager->flush();
    }
}
