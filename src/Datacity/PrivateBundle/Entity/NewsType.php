<?php

namespace Datacity\PrivateBundle\Entity;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('title', 'text')
      ->add('message', 'textarea')
      ->add('image', new ImageType(), array('required' => false)) // Rajoutez cette ligne
    ;
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Datacity\PublicBundle\Entity\News'
    ));
  }

  public function getName()
  {
    return 'datacity_privatebundle_newstype';
  }

}