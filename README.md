FrameworkBundle
===============

Model framework for symfony
=======
# Thuata FramewrokBundle

This Bundle provides a model framework acting between controllers and
database managers.

To know more about the mechanics behind the framework and learn to use
it please visit the [Documentation](./doc/index.md)

## Installation

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require thuata/frameworkbundle "~1"
```

This command requires you to have Composer installed globally, as
explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new Thuata\FramworkBundle\ThuataFrameworkBundle(),
        );

        // ...
    }

    // ...
}
```
