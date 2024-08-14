<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\ProductPhotos;
use App\Form\DataTransformer\StringToFileTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductPhotosType extends AbstractType
{
    private $transformer;

    public function __construct(StringToFileTransformer $transformer)
    {
        $this->transformer = $transformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('filename', FileType::class, [
                'attr' => [
                    'class' => 'p-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400'
                ],
                'data_class' => null,
            ])
            // ->add('current_filename', TextType::class, [
            //     'label' => 'Current file',
            //     'mapped' => false, // Ce champ n'est pas mappé à l'entité
            //     'attr' => ['readonly' => true], // Lecture seule
            // ])
            // ->get('filename')
            // ->addModelTransformer($this->transformer)
            ->add('caption', TextType::class, [
                'attr' => [
                    'class' => 'p-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400'
                ]
            ])
            ->add('Submit', SubmitType::class, [
                'attr' => [
                    'class' => 'w-3/4 shadow bg-purple-500 hover:bg-purple-700 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductPhotos::class,
        ]);
    }
}