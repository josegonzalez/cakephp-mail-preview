Installation
------------

The only officialy supported method of installing this plugin is via composer.

Using `Composer <http://getcomposer.org/>`__
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

`View on
Packagist <https://packagist.org/packages/josegonzalez/cakephp-mail-preview>`__,
and copy the json snippet for the latest version into your project's
``composer.json``. Eg, v. 0.0.1 would look like this:

.. code:: json

    {
        "require": {
            "josegonzalez/cakephp-mail-preview": "0.0.1"
        }
    }

Enable plugin
~~~~~~~~~~~~~

You need to enable the plugin your ``config/bootstrap.php`` file:

.. code:: php

    <?php
    Plugin::load('Josegonzalez/MailPreview');

If you are already using ``Plugin::loadAll();``, then this is not
necessary.
