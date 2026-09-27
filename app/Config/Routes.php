<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Theme demo for visually debugging the Bootstrap theme (not available in production)
if (ENVIRONMENT !== 'production') {
    $routes->get('theme-demo', 'ThemeDemo::index');
}
