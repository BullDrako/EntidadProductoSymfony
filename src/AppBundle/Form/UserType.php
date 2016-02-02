<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email','email',['error_bubbling' => true, 'attr' => ['class' => 'anyclass']])//añade una clase css
            ->add('password','text',['error_bubbling' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'AppBundle\Entity\User'
            ]);
    }

    public function getName()
    {
        return 'app_bundle_user_type';
    }
}
