<?php
use Cake\Core\Configure;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\Router;

if (Configure::read('debug')) {
    return;
}

$routeClass = Configure::read('MailPreview.Routes.routeClass');
$routeClass = $routeClass ?: DashedRoute::class;

$mailPreviewPrefix = Configure::read('MailPreview.Routes.prefix');
$mailPreviewPrefix = $mailPreviewPrefix ?: '/mail-preview';
$mailPreviewPrefix = '/' . trim($mailPreviewPrefix, "\t\n\r\0\x0B/");
Router::plugin('Josegonzalez/MailPreview', ['path' => $mailPreviewPrefix], function ($routes) use ($routeClass) {
    $routes->connect('/', ['controller' => 'MailPreview', 'action' => 'index'], compact('routeClass'));
    $routes->connect('/preview', ['controller' => 'MailPreview', 'action' => 'email'], compact('routeClass'));
    $routes->connect('/preview/*', ['controller' => 'MailPreview', 'action' => 'email'], compact('routeClass'));
});
