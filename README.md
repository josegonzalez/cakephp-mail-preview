[![Build Status](https://img.shields.io/travis/josegonzalez/cakephp-mail-preview/master.svg?style=flat-square)](https://travis-ci.org/josegonzalez/cakephp-mail-preview)
[![Coverage Status](https://img.shields.io/coveralls/josegonzalez/cakephp-mail-preview.svg?style=flat-square)](https://coveralls.io/r/josegonzalez/cakephp-mail-preview?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/josegonzalez/cakephp-mail-preview.svg?style=flat-square)](https://packagist.org/packages/josegonzalez/cakephp-mail-preview)
[![Latest Stable Version](https://img.shields.io/packagist/v/josegonzalez/cakephp-mail-preview.svg?style=flat-square)](https://packagist.org/packages/josegonzalez/cakephp-mail-preview)
[![Documentation Status](https://readthedocs.org/projects/cakephp-mail-preview/badge/?version=latest&style=flat-square)](https://readthedocs.org/projects/cakephp-mail-preview/?badge=latest)
[![Gratipay](https://img.shields.io/gratipay/josegonzalez.svg?style=flat-square)](https://gratipay.com/~josegonzalez/)

# MailPreview Plugin

A simple CakePHP plugin for use with previewing emails during development.

This plugin was inspired by the Rails 4.1 feature, Action Mailer Previews, as well
as the 37signals `mail_view` gem.

Alternatives to this plugin include any of the following:

* [CatchMe](https://github.com/Pentiado/catch-me): A nodejs app to catch, display and validate emails
* [MailCatcher](https://mailcatcher.me/): A super simple SMTP server which catches any message sent to it to display in a web interface.
* [MailHog](https://github.com/mailhog/MailHog): A Web and API based SMTP testing service.
* [MailTrap](https://mailtrap.io/): An email testing service

This plugin is *specifically* meant to bring Rapid Application Development to
email development by enabling developers to simply update a template and
reload the browser. Developers are encouraged to use other tools as their
needs change.


## Requirements

* CakePHP 3.x
* PHP 5.5+

## Features

- preview HTML or plain text emails from within your web browser
- emails are reloaded with each view so you can tweak/save/refresh for instant verification
- integrates perfectly with existing test fixtures
- only exposes routes in development mode to prevent leaking into production mode

## Documentation

For documentation, please see [the docs](http://cakephp-mail-preview.readthedocs.org/en/latest/).

## License

The MIT License (MIT)

Copyright (c) 2016 Jose Diaz-Gonzalez

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
