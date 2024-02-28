<?php

namespace App\Form;

use App\Entity\AreaContacto;
use App\Entity\Contacto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ContactoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nombre', TextType::class)
        ->add('apellido', TextType::class)
        ->add('correo', EmailType::class, [
            'constraints' => [
                new Email(['message' => 'El correo electrónico "{{ value }}" no es válido.']),
            ],
        ])
        ->add('celular', TextType::class)
        ->add('areaContacto', EntityType::class, [
            'class' => AreaContacto::class,
            'choice_label' => 'nombre', // Cambia 'nombre' por el atributo correcto de tu entidad AreaContacto
        ])
        ->add('mensaje', TextareaType::class)
        ->add('submit', SubmitType::class, ['label' => 'Enviar'])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contacto::class,
        ]);
    }
}
