<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Fos\UserBundle\Decorator;

use Lyssal\EntityBundle\Decorator\AbstractDecorator;
use Lyssal\Fos\UserBundle\Entity\User;

/**
 * The Decorator class for User.
 */
class UserDecorator extends AbstractDecorator
{
    /**
     * {@inheritDoc}
     */
    public function supports($entity)
    {
        return ($entity instanceof User);
    }
}
