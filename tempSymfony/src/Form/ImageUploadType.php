<?php 

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;

class ImageUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('image', FileType::class,
        array(
            'attr' => array(
                'accept' => "image/jpeg, image/png"
            ),
            'constraints' => [
                new Image([
                    'maxWidth' => 0,
                ])
            ]
        )
    )
        ->add('submit',SubmitType::class);
    }
}