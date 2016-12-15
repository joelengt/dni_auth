<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use Illuminate\Support\Facades\DB;


// Viewer: Validation Form codigo-dni
Route::get('/', 'HomeController@index');

// Viewer: Process Facebook
Route::post('/api/socio/value', ['as' => 'validate.user', 'uses' => 'sociosController@validateSocio']);

// API: Validate to Update email user
Route::post('/api/socio/send-data', 'sociosController@updateSocio');


