<?php

namespace ReclamationBundle\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type',null,array('label'=>'Type du reclamation'))
            ->add('contenu',null,array('label'=>'Contenu du reclamation'))
            ->add('objet',null,array('label'=>'objet du reclamation'))
            ->add('decision',null,array('label'=>'decision de administration'))
            ->add('reponse',null,array('label'=>'reponse de administration'))
            ->add('nomConcerne',EntityType::class,array('class'=>'UserBundle\Entity\User','choice_label'=>'nom','placeholder' => 'entrez le nom de concerne','required' => true,'multiple' => false));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ReclamationBundle\Entity\Reclamation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'reclamationbundle_reclamation';
    }


}
