<?php

namespace EvenementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class AfficheType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type_E',ChoiceType::class,array('choices'=>array(
                'Degustation'=>'Degustation',
                'Coatching'=>'Reception',
                'Reception'=>'Reception')))
            ->add('Valider',SubmitType::class,array( 'label' => 'Chercher',
                'attr' => array('class' => 'label label-success')));
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'evenement_bundleaffiche_type';
    }


}
