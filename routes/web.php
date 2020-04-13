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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

//Auth
//Route::get('/home', ['middleware' => 'auth', 'uses' => 'HomeController@index'])->name('home'); 
//Auth and verified
//Route::get('/home', ['middleware' => ['auth','verified'], 'uses' => 'HomeController@index'])->name('home'); 
Route::get('/home', ['middleware' => ['auth'], 'uses' => 'HomeController@index'])->name('home'); 
//Perfil
Route::get('/profile', ['middleware' => ['auth'], 'uses' => 'UserController@profile'])->name('profile'); 
Route::post('/edit_profile', ['middleware' => ['auth'], 'uses' => 'UserController@update_profile']); 
//Users
Route::get('/users', ['middleware' => ['auth','verified'], 'uses' => 'UserController@index'])->name('users'); 
Route::get('/users/{search}', ['middleware' => ['auth','verified'], 'uses' => 'UserController@search']);
Route::post('/save_user', ['middleware' => ['auth','verified'], 'uses' => 'UserController@save']);
Route::get('/get_user/{id}', ['middleware' => ['auth','verified'], 'uses' => 'UserController@getone']);
Route::post('/edit_user', ['middleware' => ['auth','verified'], 'uses' => 'UserController@edit']);
Route::post('/delete_user', ['middleware' => ['auth','verified'], 'uses' => 'UserController@delete']);
//Roles
Route::get('/roles', ['middleware' => ['auth','verified'], 'uses' => 'RoleController@index'])->name('roles'); 
Route::get('/roles/{search}', ['middleware' => ['auth','verified'], 'uses' => 'RoleController@search']); 
Route::post('/save_role', ['middleware' => ['auth','verified'], 'uses' => 'RoleController@save']); 
Route::get('/get_role/{id}', ['middleware' => ['auth','verified'], 'uses' => 'RoleController@getone']);
Route::get('/get_role_permissions/{id}', ['middleware' => ['auth','verified'], 'uses' => 'RoleController@getpermissions']);
Route::post('/edit_role_permissions', ['middleware' => ['auth','verified'], 'uses' => 'RoleController@edit_permisionos']);
Route::post('/edit_role', ['middleware' => ['auth','verified'], 'uses' => 'RoleController@edit']);
Route::post('/delete_role', ['middleware' => ['auth','verified'], 'uses' => 'RoleController@delete']);
//Modules
Route::get('/modules', ['middleware' => ['auth','verified'], 'uses' => 'ModuleController@index'])->name('modules'); 
Route::get('/modules/{search}', ['middleware' => ['auth','verified'], 'uses' => 'ModuleController@search']); 
Route::post('/save_module', ['middleware' => ['auth','verified'], 'uses' => 'ModuleController@save']);
Route::get('/get_module/{id}', ['middleware' => ['auth','verified'], 'uses' => 'ModuleController@getone']);
Route::get('/get_module_permissions/{id}', ['middleware' => ['auth','verified'], 'uses' => 'ModuleController@getpermissions']);
Route::post('/edit_module_permissions', ['middleware' => ['auth','verified'], 'uses' => 'ModuleController@edit_permisionos']);
Route::post('/edit_module', ['middleware' => ['auth','verified'], 'uses' => 'ModuleController@edit']);
Route::post('/delete_module', ['middleware' => ['auth','verified'], 'uses' => 'ModuleController@delete']); 
//Submodules
Route::get('/submodules/{module}', ['middleware' => ['auth','verified'], 'uses' => 'SubmodulesController@index'])->name('submodules'); 
Route::get('/submodules/{module}/{search}', ['middleware' => ['auth','verified'], 'uses' => 'SubmodulesController@search']); 
Route::post('/save_submodule', ['middleware' => ['auth','verified'], 'uses' => 'SubmodulesController@save']);
Route::get('/get_submodule/{id}', ['middleware' => ['auth','verified'], 'uses' => 'SubmodulesController@getone']);
Route::get('/get_submodule_permissions/{id}', ['middleware' => ['auth','verified'], 'uses' => 'SubmodulesController@getpermissions']);
Route::post('/edit_submodule_permissions', ['middleware' => ['auth','verified'], 'uses' => 'SubmodulesController@edit_permisionos']);
Route::post('/edit_submodule', ['middleware' => ['auth','verified'], 'uses' => 'SubmodulesController@edit']);
Route::post('/delete_submodule', ['middleware' => ['auth','verified'], 'uses' => 'SubmodulesController@delete']); 
//Elements
Route::get('/submoduleelements/{submodule}', ['middleware' => ['auth','verified'], 'uses' => 'SubmodulesElementsController@index'])->name('submoduleelements'); 
Route::get('/submoduleelements/{submodule}/{search}', ['middleware' => ['auth','verified'], 'uses' => 'SubmodulesElementsController@search']); 
Route::post('/save_submoduleelements', ['middleware' => ['auth','verified'], 'uses' => 'SubmodulesElementsController@save']);
Route::get('/get_submoduleelements/{id}', ['middleware' => ['auth','verified'], 'uses' => 'SubmodulesElementsController@getone']);
Route::post('/edit_submoduleelements', ['middleware' => ['auth','verified'], 'uses' => 'SubmodulesElementsController@edit']);
Route::post('/delete_submoduleelements', ['middleware' => ['auth','verified'], 'uses' => 'SubmodulesElementsController@delete']); 

//Utilitarios
Route::post('/search', ['middleware' => ['auth','verified'], 'uses' => 'SearchController@index']); 