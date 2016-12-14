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


// Formulario de Inicio
Route::get('/', function () {
    return view('welcome');
});

// Viewer Facebook => success
Route::post('/api/socio-value', 'sociosController@data');

// API Get => Routes 
Route::post('/api/send-data', 'sociosEmailsController@data');


