<?php

namespace App\Form;

use App\Entity\Forecast;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForecastType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'format' => 'yyyy-MM-dd',
            ])
            ->add('temperature', NumberType::class, [
                'attr' => [
                    'min' => -100,
                    'max' => 100,
                ],
            ])
            ->add('overcast', ChoiceType::class, [
                'choices' => [
                    'Clear' => 'Clear',
                    'Partly Cloudy' => 'Partly Cloudy',
                    'Cloudy' => 'Cloudy',
                    'Rain' => 'Rain',
                    'Snow' => 'Snow',
                ],
            ])
            ->add('rain', NumberType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 1000,
                ],
            ])
            ->add('wind', NumberType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 300,
                ],
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forecast::class,
        ]);
    }
}
