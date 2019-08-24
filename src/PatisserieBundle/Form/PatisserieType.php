<?php

namespace PatisserieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

class PatisserieType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('adresse')
            ->add('contact',null,array('constraints' => array(new Length(array('min' => 8)))))
            ->add('mail',null,array('constraints'=>array(new Email())))
            ->add('url',FileType::class, array('label'=>'Photo','required'=>false,))
            ->add('reservation',CheckboxType::class,array('label'=>'Permetez vous des reservations?',"value"=>1,
<<<<<<< Updated upstream
                "required"=>false,'attr'=>array('class'=>"res")))
=======
                "required"=>false))
>>>>>>> Stashed changes
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PatisserieBundle\Entity\Patisserie'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'patisseriebundle_patisserie';
    }


}
