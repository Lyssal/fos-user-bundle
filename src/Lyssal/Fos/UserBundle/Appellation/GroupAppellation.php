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
use Lyssal\Fos\UserBundle\Entity\Group;
use Lyssal\Fos\UserBundle\Decorator\GroupDecorator;

/**
 * The Appellation class for Grouo.
 */
class GroupAppellation extends AbstractAppellation
{
    use ToStringTrait;


    /**
     * {@inheritDoc}
     */
    public function supports($object)
    {
        return ($object instanceof Group || $object instanceof GroupDecorator);
    }
}
