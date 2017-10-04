<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Fos\UserBundle\Form\Type;

use Lyssal\Fos\UserBundle\Form\Transformer\RestoreRolesTransformer;
use Lyssal\Fos\UserBundle\Security\EditableRolesBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Options;

/**
 * The form to display user and group roles.
 */
class SecurityRolesType extends AbstractType
{
    protected $rolesBuilder;

    /**
     * @param EditableRolesBuilder $rolesBuilder
     */
    public function __construct(EditableRolesBuilder $rolesBuilder)
    {
        $this->rolesBuilder = $rolesBuilder;
    }


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        /**
         * The form shows only roles that the current user can edit for the targeted user. Now we still need to persist
         * all other roles. It is not possible to alter those values inside an event listener as the selected
         * key will be validated. So we use a Transformer to alter the value and an listener to catch the original values
         *
         * The transformer will then append non editable roles to the user ...
         */
        $tranformer = new RestoreRolesTransformer($this->rolesBuilder);

        // GET METHOD
        $formBuilder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($tranformer) {
            $tranformer->setOriginalRoles($event->getData());
        });

        // POST METHOD
        $formBuilder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) use ($tranformer) {
            $tranformer->setOriginalRoles($event->getForm()->getData());
        });

        $formBuilder->addModelTransformer($tranformer);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $attr = $view->vars['attr'];

        if (isset($attr['class']) && empty($attr['class'])) {
            $attr['class'] = 'sonata-medium';
        }

        $view->vars['attr'] = $attr;
        $view->vars['read_only_choices'] = $options['read_only_choices'];
    }



    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        list($roles, $rolesReadOnly) = $this->rolesBuilder->getRoles();

        $resolver->setDefaults(array(
            'choices' => function (Options $options, $parentChoices) use ($roles) {
                return empty($parentChoices) ? $roles : array();
            },

            'read_only_choices' => function (Options $options) use ($rolesReadOnly) {
                return empty($options['choices']) ? $rolesReadOnly : array();
            },

            'data_class' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'lyssal_security_roles';
    }
}
