<?php

namespace Pcdummy\AjaxCompleteBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Exception\FormException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Pcdummy\AjaxCompleteBundle\Form\DataTransformer\EntityToPropertyTransformer;

class AjaxcompleteType extends AbstractType
{

    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'entity'            => null,
            'property'          => null,
            'compound'          => false,
            'maxRows'           => 12,
        ));
    }

    public function getName()
    {
        return 'pcdummy_ajaxcomplete';
    }

    public function getParent()
    {
        return 'text';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (null === $options['entity']) {
            throw new FormException('You must provide an model entity.');
        }

        if (null === $options['property']) {
            throw new FormException('You must provide an model entity.');
        }
        
        $builder->prependClientTransformer(new EntityToPropertyTransformer(
            $options['sonata_field_description']->getAdmin()->getModelManager(),
            $options['sonata_field_description']->getTargetEntity(),
            $options['entity'],
            $options['property']
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->set('entity',  $options['entity']);
        $view->set('property',  $options['property']);
        $view->set('maxRows',   $options['maxRows']);        
    }

}