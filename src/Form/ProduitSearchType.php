<?php

namespace App\Form;

use App\Entity\ProduitSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomProduit',TextType::class,[
                'required' => false,
                'label' => false,
                'attr'=>[
                    'placeholder'=>'produits'
                ]
            ])
            ->add('nomCategorie',TextType::class,
            [
                'required' => false,
                'label' => false,
                'attr'=>[
                'placeholder'=>'categorie'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProduitSearch::class,
            'method' =>'Get',
            'csrf_protection'=>false
        ]);
    }
    

    public function getBlockPrefix(){
        return "";

    }
}
