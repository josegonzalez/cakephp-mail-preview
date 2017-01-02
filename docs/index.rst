Introduction
------------

CakePHP MailPreview Plugin
~~~~~~~~~~~~~~~~~~~~~~~~~~

A simple CakePHP plugin for use with previewing emails during development.

This plugin was inspired by the Rails 4.1 feature, Action Mailer Previews, as well
as the 37signals ``mail_view`` gem.

Alternatives to this plugin include any of the following:

* `CatchMe <https://github.com/Pentiado/catch-me>`__: A nodejs app to catch, display and validate emails
* `MailCatcher <https://mailcatcher.me/>`__: A super simple SMTP server which catches any message sent to it to display in a web interface.
* `MailHog <https://github.com/mailhog/MailHog>`__: A Web and API based SMTP testing service.
* `MailTrap <https://mailtrap.io/>`__: An email testing service

This plugin is *specifically* meant to bring Rapid Application Development to
email development by enabling developers to simply update a template and
reload the browser. Developers are encouraged to use other tools as their
needs change.

Requirements
~~~~~~~~~~~~

* CakePHP 3.x
* PHP 5.5+

What does this plugin do?
~~~~~~~~~~~~~~~~~~~~~~~~~

* preview HTML or plain text emails from within your web browser
* emails are reloaded with each view so you can tweak/save/refresh for instant verification
* integrates perfectly with existing test fixtures
* only exposes routes in development mode to prevent leaking into production mode
