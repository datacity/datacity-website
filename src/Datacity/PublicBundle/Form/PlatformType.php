<?php

namespace Datacity\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlatformType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('name',        'text')
      ->add('version',        'text')
      );
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Datacity\PublicBundle\Entity\Platform'
    ));
  }

  public function getName()
  {
    return 'datacity_publicbundle_platformtype';
  }

}