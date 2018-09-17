<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RankingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('player','entity',array('class' => 'BackendBundle:Player','choice_label' => 'getName', 'label'=> 'Jugador'))
        ->add('points', IntegerType::class, array('label' => 'Puntos: '))
        ->add('category', ChoiceType::class, array(
            'choices'  => array(                                             
                'Categoria A' => 'Categoria A',
                'Categoria B' => 'Categoria B',
                'Categoria C' => 'Categoria C',
            ),'label' => 'Categorias'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Ranking'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backendbundle_ranking';
    }


}