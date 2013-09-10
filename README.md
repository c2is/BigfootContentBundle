ContentBundle
=============

ContentBundle is part of the framework BigFoot created by C2IS.


Installation
------------

Add 'BigFoot/ContentBundle' into your composer.json file in the 'require' section:

``` json
"require": {
    ...
    ...
    "bigfoot/content-bundle": "dev-master",
}
```

Update your project:

``` shell
php composer.phar update
```

Configuration
-------------

In order to add Widgets into the dashboard section, you have to add parameters into your `config.yml` file.

```yml
# app/config/config.yml
bigfoot_content:
    widgets:
        widget_test: 'Bigfoot\Bundle\ContentBundle\Widget\WidgetTest'
        widget_most_viewed_hotel: 'Bigfoot\Bundle\ContentBundle\Widget\WidgetMostViewedHotel'
```

Usage
-----

Add a Page:

Go to the `Page` section and manage the pages.

Add a Static content:

Go to the `Static Content` and manage the static content. Note that all the static content will be listed in the `Dashboard` section.

Add a Widget:

Add the name and the class of your widget in your `config.yml` file. (see the Configuration section).

Create your class in the Widget directory, it has to extend the abstract class `AbstractWidget` located in the Model directory.

```php
/* Widget/WidgetTest.php */

namespace Bigfoot\Bundle\ContentBundle\Widget;

use Bigfoot\Bundle\ContentBundle\Model\AbstractWidget;

class WidgetTest extends AbstractWidget
{

    /**
    * The name of your Widget
    * @return Slug
    */
    public function getName()
    {
        return 'widget_test';
    }

    /**
    * Label of your Widget
    * Displayed in the Dashboard section
    */
    public function getLabel()
    {
        return 'The Widget Test';
    }

    /**
    * Parameters of your Widget
    * These parameters have to be the parameters of the target Action Controller.
    */
    public function getDefaultParameters()
    {
        return array(
            'page_id' => 1
        );
    }

    /**
    * The target Route of your Widget
    * Route of the action controller
    */
    public function getRoute()
    {
        return 'content_page';
    }

    /**
    * Form type of your Widget
    * This is the specific form of your Widget to add your custom parameters
    * The parent have to be `bigfoot_bundle_contentbundle_widgettype`
    */
    public function getParametersType()
    {
        return 'Bigfoot\Bundle\ContentBundle\Form\WidgetTestType';
    }

}
```

Create the Form Type of your Widget:

```php
/* Form/WidgetTestType.php */
namespace Bigfoot\Bundle\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WidgetTestType extends AbstractType
{

    protected $container;

    /**
     * Constructor
     *
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('page_id');

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bigfoot\Bundle\ContentBundle\Entity\Widget'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bigfoot_bundle_contentbundle_widgettesttype';
    }

    /**
    * This method has to return 'bigfoot_bundle_contentbundle_widgettype'
    * @return string
    */
    public function getParent()
    {
        return 'bigfoot_bundle_contentbundle_widgettype';
    }
}
```

Manage your sidebars
--------------------

Go to the `Dashboard` section.

Create a sidebar:

Click on the picto `New Sidebar` at the right.

Affect a Widget/Static content to a Sidebar:

At the left is listed all your Widgets and Static Contents. Drag'n'drop them to any sidebar.

Manage the order:

You can drag'n'drop any affected Widget/Static Content to sort them up. Validate by clicking on the picto at the left
of the Sidebar title.