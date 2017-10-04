# Installation

1. Update your `composer.json` :

```json
"require": {
    "lyssal/fos-user-bundle": "~x.y"
}
```

2. Update with Composer :

```sh
composer update
```

3. Create your `UserBundle`

```php
namespace Acme\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * {@inheritDoc}
 */
class AcmeUserBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'LyssalFosUserBundle';
    }
}
```

4. Create your entities

```php
namespace Acme\UserBundle\Entity;

use Lyssal\Fos\UserBundle\Entity\User as BaseUser;
use Doctrine\Orm\Mapping as Orm;

/**
 * @Orm\Table()
 * @Orm\Entity()
 */
class User extends BaseUser
{
    // Our new properties / methods
}

```

```php
namespace Acme\UserBundle\Entity;

use Lyssal\Fos\UserBundle\Entity\Group as BaseGroup;
use Doctrine\Orm\Mapping as Orm;

/**
 * @Orm\Table()
 * @Orm\Entity()
 */
class Group extends BaseGroup
{
    // Our new properties / methods
}
```

```php
namespace Acme\UserBundle\Entity;

use Lyssal\Fos\UserBundle\Entity\Title as BaseTitle;
use Doctrine\Orm\Mapping as Orm;

/**
 * @Orm\Table()
 * @Orm\Entity()
 */
class Title extends BaseTitle
{
    // Our new properties / methods
}
```

5. Redefine parameters

```xml
<?xml version="1.0" ?>
<container xmlns="http://symfony.com/schema/dic/services" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">
    <!-- ... -->
    <parameters>
        <parameter key="lyssal.fos.user.entity.title.class">Acme\UserBundle\Entity\Title</parameter>
        <parameter key="lyssal.fos.user.entity.user.class">Acme\UserBundle\Entity\User</parameter>
        <parameter key="lyssal.fos.user.entity.group.class">Acme\UserBundle\Entity\Group</parameter>
    </parameters>
</container>
```

6. Parameter FosUserBundle

See the `FOSUserBundle` documentation for more informations.

For example :

```yml
fos_user:
    db_driver: 'orm'
    firewall_name: 'main'
    user_class: 'Acme\UserBundle\Entity\User'
    group:
        group_class: 'Acme\UserBundle\Entity\Group'
```

7. Other configurations

If you use `LyssalDoctrineOrmBundle` :

```yml
imports:
    - { resource: "@LyssalFosUserBundle/Resources/config/config/manager.xml" }
```

If you use `LyssalEntityBundle` :

```yml
imports:
    - { resource: "@LyssalFosUserBundle/Resources/config/config/appellation.xml" }
    - { resource: "@LyssalFosUserBundle/Resources/config/config/decorator.xml" }
```
