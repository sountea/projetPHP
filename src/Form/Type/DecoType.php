<?php
namespace App\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DecoType extends AbstractType
{
    public Function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom',TextType::class)
            ->add('description',TextType::class)
            ->add('image',TextType::class)
            ->add('marque',TextType::class)
            ->add('Prix',IntegerType::class)
            ->add('save',SubmitType::class)
            ;

    }
}