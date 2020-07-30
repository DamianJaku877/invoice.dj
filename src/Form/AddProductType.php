<?php


namespace App\Form;


use App\Entity\Invoice;
use App\Entity\InvoiceDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddProductType extends AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameProduct', TextType::class)
            ->add('quantity', NumberType::class)
            ->add('unitPrice', NumberType::class)
            ->add("add", SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => InvoiceDetails::class]);
    }
}