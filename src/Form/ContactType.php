<?php

namespace App\Form;

use App\Entity\Departement;
use App\Entity\Messages;
use App\Entity\Purchase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Tapez votre nom'],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'Tapez votre prénom'],
            ])
            ->add('mail', EmailType::class, [
                'label' => 'Votre adresse e-mail',
                'attr' => ['placeholder' => 'Tapez votre adresse email'],
            ])
            ->add('departement', EntityType::class, [
                'label' => 'Département',
                'placeholder' => '-- Choisir un département --',
                'class' => Departement::class,
                'choice_label' => function (Departement $departement) {
                    return strtoupper($departement->getName());
                }
            ])
            ->add('object', TextType::class, [
                'label' => 'Objet du message',
                'attr' => ['placeholder' => 'Veuillez tapez votre objet']
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre message',
                'attr' => ['placeholder' => 'Veuillez tapez votre message']
            ]);
    }

}
