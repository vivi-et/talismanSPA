<?php

use App\Http\Controllers\AdminController;
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
//Tag CRUD
Route::post('/app/create_tag', 'AdminController@addTag');
Route::get('/app/get_tags', 'AdminController@getTag');
Route::post('/app/edit_tags', 'AdminController@editTag');
Route::post('/app/delete_tags', 'AdminController@deleteTag');

Route::post('/app/upload', 'AdminController@upload');
Route::post('/app/delete_image', 'AdminController@deleteImage');

//Category CRUD
Route::post('/app/create_category', 'AdminController@addCategory');
Route::get('/app/get_category', 'AdminController@getCategory');
Route::post('/app/edit_category', 'AdminController@editCategory');
Route::post('/app/delete_category', 'AdminController@deleteCategory');

Route::get('/app/get_users', 'AdminController@getUser');
Route::post('/app/create_user', 'AdminController@addUser');



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::any('{slug}', function () {
    return view('welcome');
});
