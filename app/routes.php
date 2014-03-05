<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//Route::get('/', 'DataSetController@index');
Route::get('/', array(
	'as' => 'home',
	'uses' => 'DataSetController@index'
));
Route::match(array('GET', 'POST'), '/add', array(
	'as' => 'home_add',
	'uses' => 'DataSetController@add'
));
Route::match(array('GET', 'POST'),'/edit/{id}', array(
	'as' => 'home_edit',
	'uses' => 'DataSetController@edit'
));
Route::get('/delete/{id}', array(
	'as' => 'home_delete',
	'uses' => 'DataSetController@delete'
));


/*Route::get('/', function(){
	return View::make('hello');
});*/