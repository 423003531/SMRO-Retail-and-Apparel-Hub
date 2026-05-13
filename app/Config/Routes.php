<?php
use CodeIgniter\Router\RouteCollection;
/**
 * @var RouteCollection $routes
 */
// Authentication & Core Routes
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::index');
$routes->get('logout', 'Auth::logout');
$routes->get('blocked', 'Auth::forbiddenPage');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::registration');
$routes->get('dashboard', 'Home::index');
// --------------------------------------------------------------------
// Setting Routes (Handles User Management, Roles, and Permissions)
// --------------------------------------------------------------------
$routes->group('users', static function ($routes) {
    $routes->get('/', 'Settings::users');
    $routes->post('create-role', 'Settings::createRole');
    $routes->post('update-role', 'Settings::updateRole');
    $routes->delete('delete-role/(:num)', 'Settings::deleteRole/$1');
    $routes->get('role-access', 'Settings::roleAccess');
    $routes->post('create-user', 'Settings::createUser');
    $routes->post('update-user', 'Settings::updateUser');
    $routes->delete('delete-user/(:num)', 'Settings::deleteUser/$1');
    $routes->post('change-menu-permission', 'Settings::changeMenuPermission');
    $routes->post('change-menu-category-permission', 'Settings::changeMenuCategoryPermission');
    $routes->post('change-submenu-permission', 'Settings::changeSubMenuPermission');
});
// --------------------------------------------------------------------
// Menu Management Routes
// --------------------------------------------------------------------
$routes->group('menu-management', static function ($routes) {
    $routes->get('/', 'Settings::menuManagement');
    $routes->post('create-menu-category', 'Settings::createMenuCategory');
    $routes->post('create-menu', 'Settings::createMenu');
    $routes->post('create-submenu', 'Settings::createSubMenu');
});
$routes->get('menu', 'Menu::index');
// --------------------------------------------------------------------
// Web Dashboard Routes (For UI Access)
// --------------------------------------------------------------------
$routes->group('dashboard', ['filter' => 'isLoggedIn'], static function ($routes) {
    $routes->resource('products', ['controller' => 'ProductController']);
});
// --------------------------------------------------------------------
// RESTful API Routes (For External Systems)
// --------------------------------------------------------------------
$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function ($routes) {
    $routes->resource('products', ['controller' => 'ProductController']);
});
// --------------------------------------------------------------------
// THREAD Core Modules
// --------------------------------------------------------------------
$routes->get('products', 'Products::index');
$routes->get('products/create', 'Products::create');
$routes->post('products/store', 'Products::store');
$routes->get('products/delete/(:num)', 'Products::delete/$1'); 
$routes->get('products/edit/(:num)', 'Products::edit/$1'); 
$routes->post('products/update/(:num)', 'Products::update/$1');
// Inventory Routes
$routes->get('inventory', 'Inventory::index');
$routes->post('inventory/adjust', 'Inventory::adjust');
// --- POS / ORDERS ---
$routes->get('pos', 'Pos::index');
$routes->post('pos/checkout', 'Pos::checkout');
$routes->get('sales', 'Sales::index');
$routes->get('sales/(:num)', 'Sales::show/$1');

$routes->get('sales/export', 'Sales::export');
$routes->get('inventory/export', 'Inventory::export');