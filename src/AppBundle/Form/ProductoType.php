<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre','text',['error_bubbling' => true])
            ->add('descripcion','text',['error_bubbling' => true])
            ->add('precio', 'text', ['error_bubbling' => true])
            ->add('disponible', 'text', ['error_bubbling' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'AppBundle\Entity\Producto'
            ]);

    }

    public function getName()
    {
        return 'app_bundle_producto_type';
    }
}
