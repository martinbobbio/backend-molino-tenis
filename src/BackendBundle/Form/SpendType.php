<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SpendType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('type','entity',array('class' => 'BackendBundle:Prices','choice_label' => 'getTitle', 'label'=> 'Tipo'))
        ->add('title', TextType::class, array('label' => 'Nombre '))
        ->add('price', MoneyType::class, array(
            'label' => 'Recaudación',
            'currency' => 'USD',
            'required' => true))
        ->add('count', IntegerType::class, array('scale' => 2, 'label'=> 'Cantidad', 'data'=> 1, 'attr' => array('step' => 1)));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Spend'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backendbundle_spend';
    }


}