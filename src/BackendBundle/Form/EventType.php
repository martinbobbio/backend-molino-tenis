<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', TextType::class, array('label' => 'Título: '))
        ->add('type','entity',array('class' => 'BackendBundle:TypeEvent','choice_label' => 'getTitle', 'label'=> 'Tipo de evento'))
        ->add('dateMatch', DateType::class, array(
            'widget' => 'single_text',
            'html5' => false,
            'label' => 'Fecha',
            'attr' => ['class' => 'js-datepicker',  'placeholder' => 'Elegir fecha'],))
            ->add('hour', ChoiceType::class, array(
            'choices'  => array(                                             
                '07:00' => '07:00hs','07:30' => '07:30hs',
                '08:00' => '09:00hs','08:30' => '08:30hs',
                '09:00' => '08:00hs','09:30' => '09:30hs',
                '10:00' => '10:00hs','10:30' => '10:30hs',
                '11:00' => '11:00hs','11:30' => '11:30hs',
                '12:00' => '12:00hs','12:30' => '12:30hs',
                '13:00' => '13:00hs','13:30' => '13:30hs',
                '14:00' => '14:00hs','14:30' => '14:30hs',
                '15:00' => '15:00hs','15:30' => '15:30hs',
                '16:00' => '16:00hs','16:30' => '16:30hs',
                '17:00' => '17:00hs','17:30' => '17:30hs',
                '18:00' => '18:00hs','18:30' => '18:30hs',
                '19:00' => '19:00hs','19:30' => '19:30hs',
                '20:00' => '20:00hs','20:30' => '20:30hs',
                '21:00' => '21:00hs','21:30' => '21:30hs',
                '22:00' => '22:00hs'
                
            ),'label' => 'Hora'))
            ->add('hours', ChoiceType::class, array(
            'choices'  => array(                                             
                1 => '1 hora',
                2 => '1 hora y media',
                3 => '2 horas',
                4 => '2 horas y media',
                5 => '3 horas',
            ),'label' => 'Cantidad'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Event'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backendbundle_event';
    }


}