<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description',TextType::class,[
                'attr'=>[
                    'class'=>'tweet-area'
                ]
            ])
            ->add('image', FileType::class, [
                'attr' => ['class' => 'file-upload-default'],
                'label' => 'Image De Annonce (.png file)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypesMessage' => 'Please upload a valid .png image',
                    ])
                ],
            ])
            ->add('prix',TextType::class,[
                'attr'=>[
                    'class'=>'prix-input'
                    ]
                ])
            ->add('tel',TextType::class,[
                'attr'=>[
                    'class'=>'tel-input'
                    ]
                ])
            ->add('location',TextType::class,[
                'attr'=>[
                    'class'=>'location-input'
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
