<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->post('register', 'UserController@register');
    $router->post('login', 'UserController@signIn');

    $router->group(['middleware' => 'jwt.verify'], function () use ($router) {

        /* Begin router for users */
        $router->post('logout', 'UserController@logout');
        /* Begin router for users */

        /* Begin router for posts */
        $router->get('posts', 'PostController@index');
        $router->post('posts', 'PostController@store');
        $router->get('posts/{id}', 'PostController@show');
        $router->put('posts/{id}', 'PostController@update');
        $router->delete('posts/{id}', 'PostController@destroy');
        /* End router for posts */

    });

});