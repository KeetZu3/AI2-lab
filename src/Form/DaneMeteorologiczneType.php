<?php

namespace App\Form;

use App\Entity\DaneMeteorologiczne;
use App\Entity\Miejscowosc;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DaneMeteorologiczneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('data_pomiaru', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('temperatura_w_celsjuszach', IntegerType::class)
            ->add('wilgotnosc', IntegerType::class)
            ->add('cisnienie', IntegerType::class)
            ->add('wiatr', IntegerType::class)
            ->add('location'); // pole relacyjne do Miejscowosc
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DaneMeteorologiczne::class,
        ]);
    }
}
