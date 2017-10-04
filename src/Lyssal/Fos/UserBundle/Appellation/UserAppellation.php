<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Fos\UserBundle\Appellation;

use Lyssal\Entity\Appellation\Traits\ToStringTrait;
use Lyssal\EntityBundle\Appellation\AbstractAppellation;
use Lyssal\Fos\UserBundle\Entity\User;
use Lyssal\Fos\UserBundle\Decorator\UserDecorator;

/**
 * The Appellation class for User.
 */
class TitleAppellation extends AbstractAppellation
{
    use ToStringTrait;


    /**
     * {@inheritDoc}
     */
    public function supports($object)
    {
        return ($object instanceof User || $object instanceof UserDecorator);
    }
}
