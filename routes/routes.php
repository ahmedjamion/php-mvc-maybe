<?php

declare(strict_types=1);


$router->get('/', 'MainController@index');

$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@showRegister');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');

$router->get('/profile', 'ProfileController@index');
$router->get('/home', 'HomeController@index');
$router->get('/settings', 'SettingsController@index');
$router->get('/guest', 'GuestController@index');
$router->get('/profile/details', 'ProfileController@profileDetails');
$router->get('/profile/settings', 'ProfileController@profileSettings');
