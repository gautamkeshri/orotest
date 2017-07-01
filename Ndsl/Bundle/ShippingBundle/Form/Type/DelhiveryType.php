<?php

namespace Ndsl\Bundle\ShippingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DelhiveryType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('orderNo', null, [
                    'required' => true,
                    'label' => 'ndsl_shipping.simple_crud.orderNo.label'
                ])
                ->add('name', 'text', [
                    'required' => true,
                    'label' => 'ndsl_shipping.simple_crud.name.label'
                ])
                ->add('address')
                ->add('phone')
                ->add('email','text', [
                    'required' => true,
                    'label' => 'ndsl_shipping.simple_crud.email.label'
                ])
                ->add('city','text', [
                    'required' => true,
                    'label' => 'ndsl_shipping.simple_crud.city.label'
                ])
                ->add('state','text', [
                    'required' => true,
                    'label' => 'ndsl_shipping.simple_crud.state.label'
                ])
                ->add('pincode')
                ->add('description')
                ->add('url')
                ->add('weight')
                ->add('amount')
                ->add('invoiceNo')
                ->add('qty')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Ndsl\Bundle\ShippingBundle\Entity\Delhivery'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'ndsl_shipping_crud_form';
    }

}
