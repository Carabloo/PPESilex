<?php

namespace PPESilex\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class GroupeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('nom', TextType::class, array('attr'=> array('class'=>'form-control')))
                ->add('prenom', TextType::class, array('attr'=> array('class'=>'form-control')))
                ->add('adresse', TextType::class, array('attr'=> array('class'=>'form-control')))
                ->add('tel', TextType::class, array('attr'=> array('class'=>'form-control')))
                ->add('departement', TextType::class, array('attr'=> array('class'=>'form-control')))
                ->add('specialite', TextType::class, array('attr'=> array('class'=>'form-control'),'required' => false,'empty_data' => ''))
                ->add('Envoyer', SubmitType::class, array('attr'=> array('class'=>'form-control')));
    }
}
