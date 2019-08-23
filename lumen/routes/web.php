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

use Illuminate\Http\Request;

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->get('/user', ['middleware' => 'client', 'uses' => 'AuthController@getUser']);

$router->group(['prefix'=>'api'], function() use ($router){
  $router->get('/posts', 'PostController@index');
  $router->get('/post', 'PostController@create');
  $router->get('/post/{id}', 'PostController@show');
  $router->put('/post/{id}', 'PostController@update');
  $router->delete('/post/{id}', 'PostController@destroy');

  $router->post('/login', 'AuthController@login');
  $router->post('/register', 'AuthController@register');

});
