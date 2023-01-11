<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

  // Route::resource('/', 'TemperatureController');
  Route::get('/', 'TemperatureController@index')->name('temperatures.index'); 
  Route::get('/temperatures/create', 'TemperatureController@create')->name('temperatures.create'); 
  Route::post('/temperatures/store', 'TemperatureController@store')->name('temperatures.store'); 
  Route::get('/temperatures/edit/{id}', 'TemperatureController@edit')->name('temperatures.edit'); 
  Route::post('/temperatures/update', 'TemperatureController@update')->name('temperatures.update'); 
  Route::delete('/temperatures/destroy/{id}', 'TemperatureController@destroy')->name('temperatures.destroy'); 
  