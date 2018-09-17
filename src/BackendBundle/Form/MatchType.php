<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class MatchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', TextType::class, array('label' => 'Título '))
        ->add('score', TextType::class, array('label' => 'Resultado '))
        ->add('playerWin','entity',array('class' => 'BackendBundle:Player','choice_label' => 'getName', 'label'=> 'Jugador ganador'))
        ->add('playerLoss','entity',array('class' => 'BackendBundle:Player','choice_label' => 'getName', 'label'=> 'Jugador perdedor'))
        ->add('dateMatch', DateType::class, array(
            'widget' => 'single_text',
            'html5' => false,
            'label' => 'Fecha',
            'attr' => ['class' => 'js-datepicker',  'placeholder' => 'Elegir fecha'],))
        ->add('type', ChoiceType::class, array(
            'choices'  => array(                                             
                'Amistoso' => 'Amistoso',
                'Torneo' => 'Torneo',
                'Desafio' => 'Desafio',
            ),'label' => 'Tipo de partido'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Match'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backendbundle_match';
    }


}