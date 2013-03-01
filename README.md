PcdummyAjaxCompleteBundle - adds some ajax to sonata-doctrine-orm-admin
===============================================

This bundle adds 2 new ajax enabled widgets for the sonata-admin.

###pcdummy_ajaxcomplete_m2m
[![pcdummy_ajaxcomplete_m2m](https://raw.github.com/pcdummy/AjaxCompleteBundle/master/Resources/doc/pcdummy_ajaxcomplete_m2m.png)]

Requirements
----------
* Symfony 2.1
* Sonata/DoctrineORMAdminBundle dev-master

TODO
----------
* Secure the Ajax Backend
* Check/Add configureable routes for the ajax backend

Installation
----------
* Add "pcdummy/ajaxcomplete-bundle" "dev-master" to your composer.json.
* Add it to your AppKernel.php

``` php
new Pcdummy\AjaxCompleteBundle\PcdummyAjaxCompleteBundle(),
```

* Register the widgets with twig:

``` php
  twig:
    form:
      resources:
        - PcdummyAjaxCompleteBundle::fields.html.twig
```

* Now you can use it in your admin like this:

``` php
  ->add('printer_manufacturer', 'pcdummy_ajaxcomplete', array('entity' => "PcdummyPrinterBundle:Manufacturer", 'property' => "name", 'maxRows' => 15))
  ->add('catridges', 'pcdummy_ajaxcomplete_m2m', array(
      'required' => false,
      'expanded' => true,
      'multiple' => true,
  ))
```

LICENSE
----------
MIT
