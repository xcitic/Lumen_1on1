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



$router->group(['prefix'=>'api/v1'], function() use ($router){
  $router->get('/posts', 'PostController@index');
  $router->get('/post', 'PostController@create');
  $router->get('/post/{id}', 'PostController@show');
  $router->put('/post/{id}', 'PostController@update');
  $router->delete('/post/{id}', 'PostController@destroy');
  $router->group(['middleware' => 'client'], function () use ($router) {


    $router->post('/login', 'AuthController@login');
    $router->post('/register', 'AuthController@register');

    $router->group(['middleware' => 'auth:api'], function() use ($router) {
      $router->get('/user', function (Request $request) {
      return $request->user();
      });
    });


  });
});

//
// Route::group(['middleware' => ['auth:api', 'json_response']], function() {
// // Test Route to get current user session
// Route::get('/user', function (Request $request) {
// return $request->user();
// });
// });
