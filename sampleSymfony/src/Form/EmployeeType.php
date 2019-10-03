<?php
namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Employee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            EntityType::class,
            [
                'class' => Employee::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
                'choice_value' => 'id',
                'label' => 'Employee Name :',
                'placeholder'=>"Select Employee"
            ]
        );
    }
   

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
           
           
        ]);
    }
}
?>