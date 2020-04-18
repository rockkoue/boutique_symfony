<?php

namespace App\Form;

use App\Entity\Produits;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;

use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle_produit',TextType::class)
            ->add('prix',NumberType::class)
            ->add('description',TextType::class)
            ->add('categorie',EntityType::class, [
                'class' => Categorie::class,
                'choice_label' =>function ($category) 
                {
                    return $category->getLibelleCategorie();
                }
                
            ])
            ->add('imageFile', VichImageType::class, [
            'required' => false,
            'label'=>false,
         
            'allow_delete' => true,
            'download_label' => 'download_file',
            'download_uri' => true,
            'imagine_pattern' => 'product_photo_320x240',
            'asset_helper' => true,
            
                
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
