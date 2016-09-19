Usage
-----

Basic example
~~~~~~~~~~~~~

``MailPreview`` integrates with CakePHP's ``Mailer`` class. All mailers should use the ``Josegonzalez\Mailer\PreviewTrait`` trait. Below is an example ``UserMailer`` with a ``welcome`` email method:

... code:: php

    <?php
    namespace App\Mailer;

    use Cake\Mailer\Mailer;
    use Josegonzalez\MailPreview\Mailer\PreviewTrait;

    class UserMailer extends Mailer
    {
        use PreviewTrait;

        public function welcome($user)
        {
            $this
                ->to($user->email)
                ->subject(sprintf('Welcome %s', $user->name))
                ->template('welcome_mail') // By default template with same name as method name is used.
                ->layout('custom');
        }
    }

Next, you'll want to create a ``Preview`` class for your mailer. As mailers can have multiple methods, the associated ``Preview`` class will provide an integration point for each method. All Preview classes should extend ``Josegonzalez\MailPreview\Mailer\View\MailPreview``. Here is a ``UserMailPreview`` class to accompany our above ``UserMailer``.

.. code:: php

    <?php
    namespace App\Mailer\View;

    use Josegonzalez\MailPreview\Mailer\View\MailPreview;

    class UserMailPreview extends MailPreview
    {
        public function welcome()
        {
            $this->loadModel('Users');
            $user = $this->Users->find()->first();
            return $this->getMailer('User')
                        ->preview('welcome', [$user]);
        }
    }


A few things to note here:

- ``MailPreview`` classes are in the ``App\Mailer\View`` namespace, and **must** extend the ``Josegonzalez\MailPreview\Mailer\View\MailPreview`` class. The path to the MailPreview class is ``src/Mailer/View/ClassName.php``.
- The return function of each mailer **must** be the result of the ``->preview()`` call on the ``Mailer`` object. This is injected into the class by our aforementioned ``Josegonzalez\MailPreview\Mailer\PreviewTrait``.
- The ``->preview()`` call uses the ``Cake\Mailer\Transport\DebugTransport`` email transport to retrieve the results of the sent email without actually sending it, and also injects some extra metadata for use in the ui.
- The ``->preview()`` call has the same api as the ``->send()`` call from the ``Mailer`` class.

Once we have our ``UserMailPreview`` class in place, we can view them at the ``/mail-preview`` url of your application. This route is loaded by the plugin routes, so be sure to have those enabled when you install the plugin.
