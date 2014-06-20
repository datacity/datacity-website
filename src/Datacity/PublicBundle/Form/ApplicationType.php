<?php

namespace Datacity\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ApplicationType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('name', 'text')
      ->add('url', 'text')
      ->add('downloaded','integer')
      ->add('description', 'text')
      ->add('rating', 'integer')
      ->add('image', new ImageType(), array('required' => false)) // Rajoutez cette ligne
      ->add('city', new CityType())
      ->add('platform', new PlatformType())        
      );
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Datacity\PublicBundle\Entity\Application'
    ));
  }

  public function getName()
  {
    return 'datacity_publicbundle_applicationtype';
  }

}