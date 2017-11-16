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
      $long=count($options['data'][0]);
      for ($i=0;$i<$long;$i++)
      {
          $tab[$options['data'][0][$i]['nom']." ".$options['data'][0][$i]['prenom']]=$options['data'][0][$i]['id'];
      }
      $long2=count($options['data'][1]);
      for ($i=0;$i<$long2;$i++)
      {
          $tab2[$options['data'][1][$i]['motif']]=$options['data'][1][$i]['motif'];
      }
      $long3=count($options['data'][2]);
      for ($i=0;$i<$long2;$i++)
      {
          $tab3[$options['data'][2][$i]['nomCommercial']]=$options['data'][2][$i]['id'];
      }

        $builder ->add('date', DateType::class, array('attr'=> array('class'=>'form-control'), 'widget'=>'single_text'))
                ->add('bilan', TextType::class, array('attr'=> array('class'=>'form-control')))
                ->add('idVisiteur', TextType::class, array('attr'=> array('class'=>'form-control')))
                ->add('idMedecin', ChoiceType::class, array('attr'=> array('class'=>'form-control'), 'choices' => $tab))
                ->add('motif', ChoiceType::class, array('attr'=> array('class'=>'form-control'), 'choices' => $tab2))
                ->add('idMedicament', ChoiceType::class, array('attr'=> array('class'=>'form-control'), 'choices' => $tab3))
                ->add('quantite', IntegerType::class, array('attr'=> array('class'=>'form-control')))
                ->add('Envoyer', SubmitType::class, array('attr'=> array('class'=>'form-control')));
    }
}
