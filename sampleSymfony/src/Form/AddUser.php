<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class AddUser extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class);
        $builder->add('email_id', TextType::class);
        $builder->add('date_of_birth', DateType::class,[
            'widget' => 'single_text',]);
        $builder->add('country', ChoiceType::class, [
            'choices' => [
                'India' => 'India',
                'China' => 'China',
                'Japan'   => 'Japan',
                'Russia' => 'Russia',
                'United States' => 'United States',
                'Indonesia' => 'Indonesia',
            ]]);
        $builder->add('gender',  ChoiceType::class, array(
            'choices' => array(
              'Male' => 'male',
              'Female' => 'female',
            ),
            'multiple' => false,
            'expanded' => true,
            'required' => true,));

        $builder->add('comments',TextType::class);
        $builder->add('submit',SubmitType::class);
        ;
    }
}