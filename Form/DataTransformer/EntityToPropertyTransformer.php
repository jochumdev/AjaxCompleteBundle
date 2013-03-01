<?php

namespace Pcdummy\AjaxCompleteBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Util\PropertyPath;

use Sonata\AdminBundle\Model\ModelManagerInterface;

class EntityToPropertyTransformer implements DataTransformerInterface
{
    protected $entity;
    protected $property;
    protected $class;
    
    /**
     * @var Sonata\AdminBundle\Model\ModelManagerInterface
     */
    protected $mm;

    public function __construct(ModelManagerInterface $mm, $class, $entity, $property)
    {
        $this->mm = $mm;
        $this->class = $class;
        $this->entity = $entity;
        $this->property = $property;

    }

    public function transform($entity)
    {
        if (null === $entity) {
            return null;
        }

        if ($this->property) {
            $propertyPath = new PropertyPath($this->property);
            return $propertyPath->getValue($entity);
        }

        return current($this->unitOfWork->getEntityIdentifier($entity));
    }


    public function reverseTransform($prop_value)
    {
        if (!$prop_value) {
            return null;
        }
        
        //$entity = $this->mm->find($this->class, 1);
        $entity = $this->mm->findOneBy($this->class, array($this->property => $prop_value));

        return $entity;
    }
}

