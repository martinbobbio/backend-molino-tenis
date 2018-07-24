<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PricesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', TextType::class, array('label' => 'Título: '))
        ->add('type', ChoiceType::class, array(
            'choices'  => array(                                             
                'Clases' => 'Clases',
                'Articulo' => 'Articulo',
                'Promoción' => 'Promoción',
                'Otro' => 'Otro',
            ),'label' => 'Tipo'))
        ->add('price', MoneyType::class, array(
            'label' => 'Recaudación',
            'currency' => 'USD',
            'required' => false,
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Prices'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backendbundle_prices';
    }


}