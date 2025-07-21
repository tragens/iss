<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');


// $routes->setAutoRoute(false);  // Disable auto-routing

// Define routes for your methods
$routes->get('/', 'Home::index');
$routes->get('entry', 'Home::entry');
$routes->get('report', 'Home::report');
$routes->get('setup', 'Home::setup');
$routes->get('questions', 'Home::fetchQuestions');
$routes->post('entrySave', 'Home::entrySave');
$routes->get('fetchEntry', 'Home::fetchEntry');
