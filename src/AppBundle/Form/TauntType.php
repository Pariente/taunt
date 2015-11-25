<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{

  public function getName()
  {
    return "Search";
  }

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('title', 'text',  array('label' => 'Rechercher'))
  }

}
