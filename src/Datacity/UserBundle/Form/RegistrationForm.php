<?php

namespace Datacity\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationForm extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder->add('firstname', null, array(
    			'label'  => 'register.firstname'));
    	$builder->add('lastname', null, array(
    			'label'  => 'register.name'));
        $builder->add('receiveNewsletter', null, array(
                'label'  => 'register.newsletter'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain'  => 'registerContent'
        ));
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'datacity_user_registration';
    }
}