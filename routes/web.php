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

Route::get('/test', [
	'middleware' => ['auth'], //condicionar ruta (en vez de controlador) que use tal middleware
	'uses' => function () {
		//funcion anonima que controla la ruta  , use especifica el controllador para la ruta
		return view('welcome');
	}]);

Auth::routes(); //rutas auth laravel

Route::get('/home', 'HomeAdminController@index'); // @index especifica el metodo del controllador para la ruta

/** RUTAS DEL AREA DE USUARIOS NORMALES O FRONT / */
Route::group(['prefix' => '/'], function () {
	//group nos permite agrupas rutas a un prefijo como admin

	Route::get('/', function () { //acceso a "/" root por ::get (desde url)
		return view('welcome'); //retorna el nombre de la vista desde "/resources/views/"
	});

	Route::get('/home', 'HomeController@index'); //acesso por get a la ruta especificada con su respectivo controllador

	Route::resource('files', 'FilesController'); //las rutas 'resource'  contienen todos los methodos para un CRUD sin tener que usar @ para cada uno
	Route::resource('folders', 'FoldersController'); //las rutas 'resource'  contienen todos los methodos para un CRUD sin tener que usar @ para cada uno
	Route::resource('ext', 'ExtensionsController'); //las rutas 'resource'  contienen todos los methodos para un CRUD sin tener que usar @ para cada uno
	Route::resource('logs', 'LogsController'); //las rutas 'resource'  contienen todos los methodos para un CRUD sin tener que usar @ para cada uno
	Route::resource('users', 'UsersController'); //las rutas 'resource'  contienen todos los methodos para un CRUD sin tener que usar @ para cada uno

	Route::get('files/get/{file_id}', [ // al usa { }  se le dice que puede pasarse un parametro que el methodo en el controlador recibe ()
		'uses' => 'FilesController@get', //se especifica @ el methodo directo para la ruta
		'as' => 'files.get']//se crea un alias para poder utilizar mas facil dentro de la funcion route(...)
	);

});

/** RUTAS DEL AREA DE ADMINISTRACION */
Route::group(['prefix' => 'admin'], function () {
	//group nos permite agrupas rutas a un prefijo como admin

	Route::get('/', 'Admin\HomeAdminController@index'); //acesso por get a la ruta especificada con su respectivo controllador
	Route::get('/home', 'Admin\HomeAdminController@index'); //acesso por get a la ruta especificada con su respectivo controllador

	Route::resource('files', 'Admin\FilesController'); //las rutas 'resource'  contienen todos los methodos para un CRUD sin tener que usar @ para cada uno
	Route::resource('folders', 'Admin\FoldersController'); //las rutas 'resource'  contienen todos los methodos para un CRUD sin tener que usar @ para cada uno
	Route::resource('ext', 'Admin\ExtensionsController'); //las rutas 'resource'  contienen todos los methodos para un CRUD sin tener que usar @ para cada uno
	Route::resource('logs', 'Admin\LogsController'); //las rutas 'resource'  contienen todos los methodos para un CRUD sin tener que usar @ para cada uno
	Route::resource('users', 'Admin\UsersController'); //las rutas 'resource'  contienen todos los methodos para un CRUD sin tener que usar @ para cada uno

	Route::get('files/{id}/destroy', [ // al usa { }  se le dice que puede pasarse un parametro que el methodo en el controlador recibe ()
		'uses' => 'Admin\FilesController@destroy', //se especifica @ el methodo directo para la ruta
		'as' => 'admin.files.destroy', //se crea un alias para poder utilizar mas facil dentro de la funcion route(...)
	]);

	Route::get('files/get/{file_id}', [ // al usa { }  se le dice que puede pasarse un parametro que el methodo en el controlador recibe ()
		'uses' => 'Admin\FilesController@get', //se especifica @ el methodo directo para la ruta
		'as' => 'admin.files.get']//se crea un alias para poder utilizar mas facil dentro de la funcion route(...)
	);

	Route::get('folders/{id}/destroy', [ // al usa { }  se le dice que puede pasarse un parametro que el methodo en el controlador recibe ()
		'uses' => 'Admin\FoldersController@destroy', //se especifica @ el methodo directo para la ruta
		'as' => 'admin.folders.destroy', //se crea un alias para poder utilizar mas facil dentro de la funcion route(...)
	]);

	Route::get('ext/{id}/destroy', [
		'uses' => 'Admin\ExtensionsController@destroy',
		'as' => 'admin.ext.destroy',
	]);
	Route::get('logs/{id}/destroy', [
		'uses' => 'Admin\LogsController@destroy',
		'as' => 'admin.logs.destroy',
	]);
	Route::get('users/{id}/destroy', [
		'uses' => 'Admin\UsersController@destroy',
		'as' => 'admin.users.destroy',
	]);

});
