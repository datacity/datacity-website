<?php

namespace Datacity\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationForm extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder->add('firstname', null, array(
    			'label'  => 'Prénom :'));
    	$builder->add('lastname', null, array(
    			'label'  => 'Nom :'));
        parent::buildForm($builder, $options);

    }

    public function getName()
    {
        return 'datacity_user_registration';
    }
}