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

$router->get('captcha', 'Api\TestApiController@getCaptcha');
$router->get('/test', 'Api\TestApiController@test');

$router->group(['middleware' => "AdminGuard"], function () use ($router) {
   $router->get('go', function (){
       return 123;
   });
});