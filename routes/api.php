<?php
// routes/api.php

/** @var \Laravel\Lumen\Routing\Router $router */

// Rutas para prueba y verificación de la API
$router->get('/', function () use ($router) {
    return response()->json([
        'name' => 'Turismo CDMX API',
        'version' => '1.0.0',
        'framework' => $router->app->version()
    ]);
});

// Rutas de autenticación
$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    $router->get('me', ['middleware' => 'auth', 'uses' => 'AuthController@me']);
});

// Rutas para categorías
$router->group(['prefix' => 'categories'], function () use ($router) {
    $router->get('/', 'CategoryController@index');
    $router->post('/', ['middleware' => 'auth', 'uses' => 'CategoryController@store']);
    $router->get('/{id}', 'CategoryController@show');
    $router->put('/{id}', ['middleware' => 'auth', 'uses' => 'CategoryController@update']);
    $router->delete('/{id}', ['middleware' => 'auth', 'uses' => 'CategoryController@destroy']);
});

// Rutas para lugares
$router->group(['prefix' => 'places'], function () use ($router) {
    $router->get('/', 'PlaceController@index');
    $router->post('/', ['middleware' => 'auth', 'uses' => 'PlaceController@store']);
    $router->get('/{id}', 'PlaceController@show');
    $router->put('/{id}', ['middleware' => 'auth', 'uses' => 'PlaceController@update']);
    $router->delete('/{id}', ['middleware' => 'auth', 'uses' => 'PlaceController@destroy']);
    $router->get('/district/{district}', 'PlaceController@getByDistrict');
});
