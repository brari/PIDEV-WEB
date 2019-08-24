<?php

namespace FeteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomF',null,array('label'=>'Nom de la fete'))
            ->add('descriptionF',null,array('label'=>'description de la fete'))
            ->add('adresseF',null,array('label'=>'adresse de la fete'))
            ->add('dateF',null,array('label'=>'date de la fete'))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FeteBundle\Entity\Fete'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fetebundle_fete';
    }


}
