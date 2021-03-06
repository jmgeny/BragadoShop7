<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Gate;
use App\User;



Route::get('/prueba', function () {

    //Purebo si el usuario conectado tiene el permiso requereido para esta ruta
    Gate::authorize('haveaccess','role.show');
    $usuario = App\User::findOrFail(2);
 
    return $usuario;

});

Route::get('/resultado', function () {
    
    $images = App\Image::orderBy('id','desc')->get();
    $usuario = App\User::findOrFail(1);
    $producto = App\Product::with('images')->find(5);

    return $producto;
});



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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function(){
	return view('tienda.index');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Admin de productos y categorias

Route::resource('/admin/product','Admin\AdminProductController')->names('admin.product');
Route::resource('/admin/category','Admin\AdminCategoryController')->names('admin.category');

Route::get('/admin', function(){
	return view('admin.index');
})->name('admin');

Route::get('cancelar/{ruta}',function($ruta){
	return redirect()->route($ruta)->with('cancelar','La accion fue cancelada');
})->name('cancelar');

// Rutas para roles
Route::resource('/role','RoleController')->names('role');
Route::resource('/user','UserController')->except(['create','store'])->names('user');