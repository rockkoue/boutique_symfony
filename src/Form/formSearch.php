<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class formSearch extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('p', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'produits'
                ]
            ])
           ->add('categorie',EntityType::class,
                    
           [
               'label' => false,
                'class' => Categorie::class,
                'choice_label' =>function ($category) 
                {
                    return $category->getLibelleCategorie();
                }
                
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'Get',
            'csrf_protection' => false
        ]);
    }


    public function getBlockPrefix()
    {
        return "";
    }
}
