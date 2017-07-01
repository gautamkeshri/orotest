<?php
namespace Ndsl\Bundle\ShippingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class slistType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('refnumber')
            ->add('isGenerate','choice',[
                'choices' => [
                    'Yes' => true,
                    'No' => false,
                ]
            ])
            ->add('awbno')
            ->add('destArea')
            ->add('destLoc')
            ->add('warehouseCode')
            ->add('status')
//            ->add('delhivery','entity',[
//                'class' => 'NdslShippingBundle:slist',
//                'choice_label' => 'delhivery',
//            ])    
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ndsl\Bundle\ShippingBundle\Entity\slist'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ndsl_awb_crud_form';
    }
}
