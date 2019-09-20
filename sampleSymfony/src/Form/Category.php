<?php

namespace App\Form;

use App\Entity\MainCategory;
use App\Entity\SubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class Category extends AbstractType
{
    private $em;
    
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
                'label' => 'Select Main-Category',
                ]);
                       
            $builder->add('submit',SubmitType::class);
    }

    
    
}