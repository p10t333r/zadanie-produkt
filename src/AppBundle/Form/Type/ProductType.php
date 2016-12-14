<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductType extends AbstractType {

    public function getName() {
        return 'addProduct';
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', TextType::class, array(
                    'label' => 'Nazwa'
                ))
                ->add('description', TextareaType::class, array(
                    'label' => 'Opis'
                ))
                ->add('price', MoneyType::class, array(
                    'label' => 'Cena',
                    'currency' => 'PLN',
                    'scale' => 2
                ))
                ->add('Zapisz', SubmitType::class);
    }

}
