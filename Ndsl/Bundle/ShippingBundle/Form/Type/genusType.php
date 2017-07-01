<?php
namespace Ndsl\Bundle\ShippingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class genusType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('invoice','text', [
                    'required' => true,
                    'label' => 'ndsl_shipping.genus_info.invoice.label'
                ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ndsl\Bundle\ShippingBundle\Entity\genus'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ndsl_genus_crud_form';
    }
}
