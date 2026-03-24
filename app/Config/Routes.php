<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Admin routes
$routes->get('/admin', 'Admin\Home::index');

// Admin taglines routes
$routes->get('/admin/taglines', 'Admin\Taglines::index');
$routes->get('/admin/taglines/create', 'Admin\Taglines::create');
$routes->post('/admin/taglines/store', 'Admin\Taglines::store');
$routes->get('/admin/taglines/edit/(:num)', 'Admin\Taglines::edit/$1');
$routes->post('/admin/taglines/update/(:num)', 'Admin\Taglines::update/$1');
$routes->post('/admin/taglines/delete', 'Admin\Taglines::delete');
$routes->post('/admin/taglines/move-up/(:num)', 'Admin\Taglines::moveUp/$1');
$routes->post('/admin/taglines/move-down/(:num)', 'Admin\Taglines::moveDown/$1');
$routes->post('/admin/taglines/toggle/(:num)', 'Admin\Taglines::toggle/$1');

// Admin bio routes
$routes->get('/admin/bio', 'Admin\Bio::index');
$routes->post('/admin/bio/store', 'Admin\Bio::store');
$routes->post('/admin/bio/activate/(:num)', 'Admin\Bio::activate/$1');

// Admin cache routes
$routes->get('/admin/cache', 'Admin\Cache::index');
$routes->post('/admin/cache/clear', 'Admin\Cache::clear');
$routes->post('/admin/cache/delete', 'Admin\Cache::delete');

// Admin GitHub activity routes
$routes->get('/admin/github-activity', 'Admin\GitHubActivity::index');
$routes->get('/admin/github-activity/datatable', 'Admin\GitHubActivity::datatable');
$routes->post('/admin/github-activity/delete', 'Admin\GitHubActivity::delete');

// API routes
$routes->match(['get', 'options'], '/api/test/ping', 'Api\Test::ping');

// Command line routes
$routes->cli('cli/test/index/(:segment)', 'CLI\Test::index/$1');
$routes->cli('cli/test/count', 'CLI\Test::count');
$routes->cli('cli/fetch-github-activity', 'CLI\FetchGitHubActivity::index');

// Metrics route
$routes->post('/metrics/receive', 'Metrics::receive');

// Contact routes
$routes->get('/contact', 'Contact::index');
$routes->post('/contact/send', 'Contact::send');

// Logout route
$routes->get('/logout', 'Auth::logout');

// Unauthorised route
$routes->get('/unauthorised', 'Unauthorised::index');

// Custom 404 route
$routes->set404Override('App\Controllers\Errors::show404');

// Debug routes
$routes->get('/debug', 'Debug\Home::index');
$routes->get('/debug/(:segment)', 'Debug\Rerouter::reroute/$1');
$routes->get('/debug/(:segment)/(:segment)', 'Debug\Rerouter::reroute/$1/$2');
