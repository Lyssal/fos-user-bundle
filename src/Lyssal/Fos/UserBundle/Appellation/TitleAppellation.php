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
use Lyssal\Fos\UserBundle\Entity\Title;
use Lyssal\Fos\UserBundle\Decorator\TitleDecorator;

/**
 * The Appellation class for Title.
 */
class TitleAppellation extends AbstractAppellation
{
    use ToStringTrait;


    /**
     * {@inheritDoc}
     */
    public function supports($object)
    {
        return ($object instanceof Title || $object instanceof TitleDecorator);
    }
}
