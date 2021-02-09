<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Tag;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['new']) {
            $builder ->add('name', TextType::class, [
                'label' => 'Nom'
            ]);
        }

        $builder
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('averagePrice', IntegerType::class, [
                'label' => 'Prix Moyen',
                'required' => false
            ])
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'label' => 'Auteur de cet ouvrage'
            ])
            ->add('test', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'In Stock' => true,
                    'Out of Stock' => false,
                ],
                'multiple' => true,
                'required' => false
            ])
            ->add('publicationDate', CheckboxType::class, [
                'label' => 'Publier ce livre ?',
                'required' => false
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'image_uri' => true
            ])
            ->add('tags', CollectionType::class, [
                'entry_type' => TagType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
            ])
        ;

        $builder->get('publicationDate')
            ->addModelTransformer(new CallbackTransformer(
                function ($publicationDateToBoolean) {
                    // To boolean (Form)
                    return $publicationDateToBoolean ? true : false;
                },
                function ($publicationDateToDatetime) {
                    // To datetime (Entity)
                    return $publicationDateToDatetime ? new \DateTime() : null;
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'new' => false
        ]);
    }
}
