<?php

namespace EvenementBundle\Form;

use EvenementBundle\EvenementBundle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;


class EvenementsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getName() {
        return "insep_sitebundle_datetype";
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_E',CKEditorType::Class)
            ->add('description_E',null,array('label'=> 'description_E','attr'=>array('class'=>'text-muted m-b-15 f-s-12 form-control input-focus')))
            ->add('adresse_E',null,array('label'=> 'nom_E','attr'=>array('class'=>'text-muted m-b-15 f-s-12 form-control input-focus')))
            ->add('type_E',ChoiceType::class,array('choices'=>array(
                'Degustation'=>'Degustation',
                'Coatching'=>'Reception',
                'Reception'=>'Reception')))
            ->add('date_E',DateType::class,array('years' => range(1900, 2050),'data'  => date_create()))
            ->add('image_E', FileType::class, array('data_class' => null,'label' => 'insérer une image','attr'=>array('class'=>'text-muted m-b-15 f-s-12 form-control input-focus')))
            ->add('interesses')
            ->add('capacite');



    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EvenementBundle\Entity\Evenements'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'evenementbundle_evenements';
    }


}
