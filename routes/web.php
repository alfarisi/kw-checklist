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

$router->group(['middleware' => 'auth'], function () use ($router) {
	$router->get('checklists/templates',  ['uses' => 'TemplateController@index']);
	$router->get('checklists/templates/{id}', ['uses' => 'TemplateController@detail']);
	$router->post('checklists/templates', ['uses' => 'TemplateController@create']);
	$router->delete('checklists/templates/{id}', ['uses' => 'TemplateController@delete']);
	$router->patch('checklists/templates/{id}', ['uses' => 'TemplateController@update']);
	//$router->post('checklists/templates/{id}/assigns', ['uses' => 'TemplateController@assign']);
});
