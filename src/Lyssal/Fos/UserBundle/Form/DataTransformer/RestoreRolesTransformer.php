<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Fos\UserBundle\Form\DataTransformer;

use Lyssal\Fos\UserBundle\Security\EditableRolesBuilder;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * The data transformer for the user and group roles.
 */
class RestoreRolesTransformer implements DataTransformerInterface
{
    /**
     * @var array The original roles
     */
    protected $originalRoles;

    /**
     * @var \Lyssal\Fos\UserBundle\Security\EditableRolesBuilder The roles builder
     */
    protected $rolesBuilder;


    /**
     * The constructor.
     *
     * @param \Lyssal\Fos\UserBundle\Security\EditableRolesBuilder $rolesBuilder The roles builder
     */
    public function __construct(EditableRolesBuilder $rolesBuilder)
    {
        $this->rolesBuilder = $rolesBuilder;
    }


    /**
     * @param array $originalRoles
     */
    public function setOriginalRoles($originalRoles)
    {
        $this->originalRoles = $originalRoles;
    }


    /**
     * {@inheritDoc}
     */
    public function transform($value)
    {
        if ($value === null) {
            return $value;
        }

        if ($this->originalRoles === null) {
            throw new \RuntimeException('Invalid state, originalRoles array is not set');
        }

        return $value;
    }

    /**
     * {@inheritDoc}
     */
    public function reverseTransform($selectedRoles)
    {
        if ($this->originalRoles === null) {
            throw new \RuntimeException('Invalid state, originalRoles array is not set');
        }

        list($availableRoles, ) = $this->rolesBuilder->getRoles();

        $hiddenRoles = array_diff($this->originalRoles, $availableRoles);

        return array_merge($selectedRoles, $hiddenRoles);
    }
}
