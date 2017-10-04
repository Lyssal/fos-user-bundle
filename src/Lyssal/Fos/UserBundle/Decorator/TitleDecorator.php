<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Fos\UserBundle\Decorator;

use Lyssal\EntityBundle\Decorator\AbstractDecorator;
use Lyssal\Fos\UserBundle\Entity\Title;

/**
 * The Decorator class for Title.
 */
class TitleDecorator extends AbstractDecorator
{
    /**
     * {@inheritDoc}
     */
    public function supports($entity)
    {
        return ($entity instanceof Title);
    }
}
