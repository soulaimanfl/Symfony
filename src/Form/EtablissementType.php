<?php

namespace App\Form;

use App\Entity\Etablissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// Importez le DateType ici
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class EtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('appellationOfficielle', null, [
                'label' => 'Appellation officielle',
            ])
            ->add('denominationPrincipale')
            ->add('secteur')
            ->add('longitude')
            ->add('latitude')
            ->add('secteur', ChoiceType::class, [
                'label' => 'Secteur',
                'choices' => [
                    'Privé' => 'privé',
                    'Public' => 'public',
                ],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('adresse', null, [
                'required' => true,
            ])
            ->add('departement')
            ->add('commune')
            ->add('region')
            ->add('academie')
            ->add('dateOuverture', DateType::class, [
                // Permet aux utilisateurs de sélectionner une date avec un seul champ de texte.
                'attr' => ['class' => 'form-control'],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etablissement::class,
        ]);
    }
}
