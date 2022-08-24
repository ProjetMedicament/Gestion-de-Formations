<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\Visa;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as SFType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('dateSortie')
            ->add('resume')
            ->add('studio', EntityType::class, array('class' => 'App\Entity\Studio','choice_label' => 'nom',))
            ->add('acteurs', EntityType::class, array('class' => 'App\Entity\Acteur','choice_label' => 'prenom','multiple'=>true,'expanded'=>true))
            ->add('Numero')
            ->add('Pays', EntityType::class, array('class' => 'App\Entity\Visa','choice_label' => 'pays',))
            ->add('save', SFType\SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}
