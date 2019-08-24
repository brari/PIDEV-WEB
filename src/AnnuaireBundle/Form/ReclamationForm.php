<?php
namespace AnnuaireBundle\Form;

use UserBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



/**
 * Created by PhpStorm.
 * User: ines2016
 * Date: 23/11/2016
 * Time: 03:01
 */
class ReclamationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    { $builder
           //->add('iduserrec',EntityType::class,array('class'=>'UserBundle:User','choice_label'=>'username','multiple'=>false,))
            //->add('iduseradmin',EntityType::class,array('class'=>'UserBundle:User','choice_label'=>'email','multiple'=>false,))
             ->add('title')
             ->add('core')
        ->add('date')
        ->add('isdisabled')
        ->add('iduser')
        ->add('theme', 'entity')

        ->add('Submit',SubmitType::class);

}
    public function configureOptions(OptionsResolver $resolver){

    }
    public function getName(){
        return 'annuaire_bundle_subject';
    }
//    public function getBlockPrefix()
//    {
//        return 'AnnuaireBundle_reclamation';
//    }
}