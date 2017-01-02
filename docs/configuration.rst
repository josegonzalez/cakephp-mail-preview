Plugin configuration options
============================

This plugin can be configured via your ``config/app.php``. Here is an example
config stanza:

.. code:: php

    /**
     * Configures the MailPreview plugin
     */
    'MailPreview' => [
        'Routes' => [
            // the router class for the MailPreview plugin
            'class' => 'Cake\Routing\Route\DashedRoute',
            // prefix to use for accessing the MailPreview plugin routes
            'prefix' => '/mail-preview',
        ],
        'Previews' => [
            // A list of classNames to override the automatically detected classes
            // Useful when loading previews from plugins
            'classNames' => [
                'App\Mailer\Preview\UserMailPreview',
            ],
        ],
    ],
