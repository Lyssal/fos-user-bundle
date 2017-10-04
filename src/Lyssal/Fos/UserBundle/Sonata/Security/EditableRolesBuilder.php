<?php
namespace Lyssal\Fos\UserBundle\Sonata\Security;

use Sonata\AdminBundle\Admin\Pool;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Translation\TranslatorInterface;

class EditableRolesBuilder
{
    protected $tokenStorage;

    protected $authorizationChecker;

    protected $pool;

    protected $rolesHierarchy;

    protected $translator;

    /**
     * @param Pool                     $pool
     * @param array                    $rolesHierarchy
     */
    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker, Pool $pool, array $rolesHierarchy = array(), TranslatorInterface $translator)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
        $this->pool = $pool;
        $this->rolesHierarchy = $rolesHierarchy;
        $this->translator = $translator;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = array();
        $rolesReadOnly = array();

        if (!$this->tokenStorage->getToken()) {
            return array($roles, $rolesReadOnly);
        }

        // get roles from the Admin classes
        foreach ($this->pool->getAdminServiceIds() as $id) {
            try {
                $admin = $this->pool->getInstance($id);
            } catch (\Exception $e) {
                continue;
            }

            $isMaster = $admin->isGranted('MASTER');
            $securityHandler = $admin->getSecurityHandler();

            $baseRole = $securityHandler->getBaseRole($admin);

            foreach ($admin->getSecurityInformation() as $role => $permissions) {
                $role = sprintf($baseRole, $role);

                if ($isMaster) {
                    // if the user has the MASTER permission, allow to grant access the admin roles to other users
                    $roles[$role] = $this->translator->trans($role, array(), 'Roles');
                } elseif ($this->authorizationChecker->isGranted($role)) {
                    // although the user has no MASTER permission, allow the currently logged in user to view the role
                    $rolesReadOnly[$role] = $role;
                }
            }
        }

        $isMaster = $this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN');

        // get roles from the service container
        foreach ($this->rolesHierarchy as $name => $rolesHierarchy)
        {
            $rolesHierarchyTraductions = $rolesHierarchy;
            foreach ($rolesHierarchyTraductions as $i => $roleHierarchy)
                $rolesHierarchyTraductions[$i] = $this->translator->trans($roleHierarchy, array(), 'Roles');

            if ($this->authorizationChecker->isGranted($name) || $isMaster) {
                $roles[$name] = $this->translator->trans($name, array(), 'Roles'). ' : ' . implode(', ', $rolesHierarchyTraductions);

                foreach ($rolesHierarchy as $role) {
                    if (!isset($roles[$role])) {
                        $roles[$role] = $this->translator->trans($role, array(), 'Roles');
                    }
                }
            }
        }

        return array($roles, $rolesReadOnly);
    }
}
