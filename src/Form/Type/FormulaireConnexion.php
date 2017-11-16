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
        $builder ->add('login', TextType::class, array('attr'=> array('class'=>'form-control')))
                ->add('password', TextType::class, array('attr'=> array('class'=>'form-control')))
                ->add('Envoyer', SubmitType::class, array('attr'=> array('class'=>'form-control')));
    }
}
                