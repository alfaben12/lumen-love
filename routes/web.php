<?php
use Illuminate\Http\Request;

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

$router->post('/signin', 'LoginController@signin');
$router->post('/signup', 'LoginController@signup');

$router->group(['prefix' => '/users'], function($router){
    $router->get('/', 'UserController@showOne');
    $router->post('/', 'UserController@store');
    $router->put('/', 'UserController@update');
    $router->delete('/', 'UserController@destroy');
});

$router->group(['prefix' => '/utterances'], function($router){
    $router->get('/', 'UtteranceController@showAll');
    $router->get('/{id}', 'UtteranceController@showOne');
    $router->post('/', 'UtteranceController@store');
    $router->put('/{id}', 'UtteranceController@update');
    $router->delete('/{id}', 'UtteranceController@destroy');
});

$router->get('/login', function (Request $request) {
    $token = app('auth')->attempt($request->only('email', 'password'));
 
    return response()->json(compact('token'));
});