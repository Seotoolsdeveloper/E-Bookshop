<?php

namespace Config;

$routes = service('routes');
// Enable auto-routing (mimics CI3 behavior)
$routes->setAutoRoute(true);


$routes->get('default_controller', 'welcome');
$routes->get('404_override', 'errors::page_missing');
$routes->get('default_controller', 'home');



// Set default namespace, controller, and method
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
//$routes->setAutoRoute(true);

// Define your routes
$routes->get('/', 'Home::index', ['as' => 'home']); // Home page
$routes->get('user-home', 'User_home::index'); // Example user home route



//product pages
$routes->get('product/(:any)', 'Users::book_view/$1', ['as' => 'users.book_view']);
$routes->post('product/(:any)', 'Users::book_view/$1');
$routes->get('users/all-books', 'Users::all_books', ['as' => 'all_books']);
$routes->get('search', 'Users::search', ['as' => 'users.search']);


//userhome
$routes->get('userhome/editprofile/(:num)', 'User_home::edit_profile/$1', ['as' => 'user.editprofile']);
$routes->post('userhome/editprofile/(:num)', 'User_home::edit_profile/$1');

$routes->get('userhome', 'User_home::index', ['as' => 'user_home']);










// Welcome (default CI page)
$routes->get('welcome', 'Welcome::index');

// User Home

$routes->get('userhome/sellbooks', 'User_home::sellbooks');
$routes->post('userhome/sellbooks', 'User_home::sellbook');
$routes->get('user-home/myBooks', 'User_home::myBooks');
$routes->get('user-home/myBooks/delete/(:num)', 'User_home::myBooks_delete/$1');
$routes->get('user-home/my-orders', 'User_home::my_orders');
$routes->get('user-home/order-view/(:num)', 'User_home::order_view/$1');


// Users Controller (Registration, Login, Logout, Books)
$routes->get('users/registration', 'Users::registration', ['as' => 'users.registration']);
$routes->post('users/registration', 'Users::registration');

$routes->get('users/login', 'Users::login', ['as' => 'users.login']);
$routes->post('users/login', 'Users::login');

$routes->get('users/logout', 'Users::logout', ['as' => 'users.logout']);

$routes->get('users/all-books', 'Users::all_books', ['as' => 'users.all_books']);
$routes->get('users/all-books/(:num)', 'Users::all_books/$1');


$routes->get('users/all-ebooks', 'Users::all_ebooks', ['as' => 'users.all_ebooks']);
$routes->get('users/ebook-view/(:num)', 'Users::ebook_view/$1', ['as' => 'users.ebook_view']);

$routes->get('users/terms', 'Users::terms', ['as' => 'users.terms']);

//$routes->post('users/search', 'Users::search', ['as' => 'users.search']);



// Cart Controller
$routes->get('cart', 'CartController::index');
$routes->post('cart/add', 'CartController::add');
$routes->post('cart/update', 'CartController::update');
$routes->get('cart/remove/(:any)', 'CartController::remove/$1');
$routes->get('cart/clear', 'CartController::clear');

// Checkout Controller
$routes->get('checkout', 'Checkout::index',['as'=>'checkout.place_order']);
$routes->post('checkout', 'Checkout::index');







/*======================== Admin Routes ========================*/
$routes->group('admin', function($routes) {
    $routes->get('', 'Admin::index');

    // Category
    $routes->get('category', 'Admin::category');
    $routes->get('add_category', 'Admin::add_category');
    $routes->post('add_category', 'Admin::add_category');
    $routes->get('ctg_view/(:num)', 'Admin::ctg_view/$1');
    $routes->get('ctg_edit/(:num)', 'Admin::ctg_edit/$1');
    $routes->post('ctg_edit/(:num)', 'Admin::ctg_edit/$1');
    $routes->get('ctg_delete/(:num)', 'Admin::ctg_delete/$1');

    // Users
    $routes->get('allusers', 'Admin::allusers');
    $routes->get('add_users', 'Admin::add_users');
    $routes->post('add_users', 'Admin::add_users');
    $routes->get('user_delete/(:num)', 'Admin::user_delete/$1');

    // Books
    $routes->get('books', 'Admin::books');
    $routes->get('add_books', 'Admin::add_books');
    $routes->post('add_books', 'Admin::add_books');
    $routes->get('book_view/(:num)', 'Admin::book_view/$1');
    $routes->get('book_edit/(:num)', 'Admin::book_edit/$1');
    $routes->post('book_edit/(:num)', 'Admin::book_edit/$1');
    $routes->get('book_delete/(:num)', 'Admin::book_delete/$1');

    // Ebooks
    $routes->get('ebooks', 'Admin::ebooks');
    $routes->get('add_ebooks', 'Admin::add_ebooks');
    $routes->post('add_ebooks', 'Admin::add_ebooks');
    $routes->get('ebook_view/(:num)', 'Admin::ebook_view/$1');
    $routes->get('delete_ebook/(:num)', 'Admin::delete_ebook/$1');

    // Orders
    $routes->get('orders', 'Admin::orders');
    $routes->get('order_view/(:num)', 'Admin::order_view/$1');
    $routes->post('acceptorder/(:num)', 'Admin::acceptorder/$1');
    
    $routes->get('delete_order/(:num)', 'Admin::delete_order/$1');

    // Delivery
    $routes->get('ready_to_deliver', 'Admin::ready_to_deliver');
    $routes->get('delivery_details/(:num)', 'Admin::delivery_details/$1');
    $routes->post('confirm_delivery/(:num)', 'Admin::confirm_delivery/$1');
    $routes->post('cancel_delivery/(:num)', 'Admin::cancel_delivery/$1');




    $routes->get('settings', 'Admin::settings', ['as' => 'admin.settings']);
    $routes->post('settings', 'Admin::settings', ['as' => 'admin.settings.save']);
});

