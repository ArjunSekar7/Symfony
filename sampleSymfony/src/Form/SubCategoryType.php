<?php

namespace App\Form;


use App\Entity\SubCategory;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SubCategoryType extends AbstractType
{
       
    /**
     * 
     * @param EntityManagerInterface $em
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sub_category_name', ChoiceType::class, array(
                'choices' => array(
                  'Select' => 0,
                ),
                'required' => true,
                'label' => false,
                ));
                       
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SubCategory::class,
        ]);
    }

    
    
}