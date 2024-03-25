<?php

namespace App\Form;

use App\Entity\Artiste;
//use Doctrine\DBAL\Types\TextType;
use App\Entity\Nationalite;
use Symfony\Component\Form\AbstractType;
use App\Repository\NationaliteRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ArtisteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label'=>"Nom de l'artiste",
                'attr'=>[
                    //'class'=>"",
                    "placeholder"=>"saisir le nom de l'artiste"
                ]
            ])
            ->add('description', TextareaType::class)
            ->add('site', UrlType::class)
            ->add('image', TextType::class, [
                'required'=>false // pour que champ en questio ne soit pas requi
            ])
            ->add('type', ChoiceType::class,[
                "choices"=>[
                    "solo"=>0,
                    "groupe"=>1
                ]
            ])

            ->add('nationalite', EntityType::class,[
                'class'=>Nationalite::class,
                'choice_label'=>'libelle',
                'required'=>false,
            ])
            //->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artiste::class,
        ]);
    }
}
