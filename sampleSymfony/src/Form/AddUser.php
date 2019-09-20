<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class AddUser extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class);
        $builder->add('email_id', EmailType::class);
        $builder->add('birthdate', BirthdayType::class, [
            'placeholder' => [
                'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
            ]
        ]);
        $builder->add('gender',  ChoiceType::class, array(
            'choices' => array(
              'Male' => 'male',
              'Female' => 'female',
            ),
            'multiple' => false,
            'expanded' => true,
            'required' => true,
            ));
            $builder->add('country', ChoiceType::class, [
                'choices' => [
                    'India' => 'India',
                    'China' => 'China',
                    'Japan'   => 'Japan',
                    'Russia' => 'Russia',
                    'United States' => 'United States',
                    'Indonesia' => 'Indonesia'
                ]]);
        $builder->add('comments',TextType::class,array('required' => false));
        $builder->add('submit',SubmitType::class);
        ;
    }
}