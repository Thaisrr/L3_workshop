<?php

namespace App\Form;

use App\Constantes\Subject;
use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'article',
                'required' => true,
                'attr' => ['maxlength' => 100]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' =>true,
                'attr' => ['maxlength' => 255]
            ])
            ->add('text', TextareaType::class, [
                'label' => 'Votre missive!',
                'required' => true
            ])
            ->add('subject')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
