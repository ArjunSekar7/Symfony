<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use App\Entity\UploadImage;


class UploadImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder  
        ->add('orginal_image_path', FileType::class, [
            'label' => 'Choose file to upload : ',
            'required' => true,
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                     ],
                    'mimeTypesMessage' => 'Please upload a valid image format',
                ])
            ],
        ])
       ->add('submit',SubmitType::class)
        ;
    }
   
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UploadImage::class,
        ]);
    }
}

?>