<?php

namespace AnnuaireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SubjectType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title')
                ->add('core', null, [
                    'attr' => [
                        'style' => 'height: 200px;',
                    ]
                ])
                ->add('theme', EntityType::class, [
                'label' => 'Théme ',
                    'class' => 'AnnuaireBundle\Entity\Themes',
                    'choice_label' => 'name',
                    'label_attr' => [
                        'class' => 'col-sm-3 control-label'
                    ],
                    'attr' => [
                        'class' => 'form-control',
                    ]
                ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AnnuaireBundle\Entity\Subject'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'annuaire_bundle_subject';
    }

}
