<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Pages::home', ['as' => 'home']);
$routes->get('about', 'Pages::about', ['as' => 'about']);
$routes->get('customers', 'Customers::index', ['as' => 'customers']);
$routes->get('customers/new', 'Customers::create', ['as' => 'customers.new']);
$routes->post('customers', 'Customers::store', ['as' => 'customers.store']);
$routes->get('customers/(:num)/edit', 'Customers::edit/$1', ['as' => 'customers.edit']);
$routes->post('customers/(:num)', 'Customers::update/$1', ['as' => 'customers.update']);
$routes->get('users', 'Users::index', ['as' => 'users']);
$routes->get('users/new', 'Users::create', ['as' => 'users.new']);
$routes->post('users', 'Users::store', ['as' => 'users.store']);
$routes->get('users/(:num)/edit', 'Users::edit/$1', ['as' => 'users.edit']);
$routes->post('users/(:num)', 'Users::update/$1', ['as' => 'users.update']);
