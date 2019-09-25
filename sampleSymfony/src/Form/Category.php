<?php

namespace App\Form;

use App\Entity\MainCategory;
use App\Entity\SubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class Category extends AbstractType
{
       
    /**
     * 
     * @param EntityManagerInterface $em
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',EntityType::class,[
                'class' => MainCategory::class,
                'choice_label'=>function(MainCategory $mainCategory) {
                return sprintf('%s', $mainCategory->getName());
                },
                'label' => false,
                ]);
                      
            
    }

    
    
}