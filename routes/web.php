<?php

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
Route::group(['middleware' => ['guest']], function () {
    Route::get('/','Auth\LoginController@showLoginForm');
    Route::post('/login','Auth\LoginController@login')->name('login');
});
//middleware auth, hace referencia a los usuarios autenticados
Route::group(['middleware' => ['auth']], function () {
    /*Cualquier Usuario autenticado podra ver lo siguiente */
    // Route::get('/dashboard','DashboardController');
    

    Route::get('/inicio', function () {
        return view('contenido/contenido');
    })->name('inicio');
    Route::group(['middleware'=>['Administrador']],function(){
        Route::post('/logout','Auth\LoginController@logout')->name('logout');
        Route::get('/miembro','MiembroController@index');
        Route::get('/miembro/datosMiembro','MiembroController@datosMiembro');
        Route::post('/miembro/registrar','MiembroController@store');
        Route::put('/miembro/actualizar','MiembroController@update');
        Route::post('/miembro/imagen','MiembroController@actualizarImagen');
        Route::get('/grupo','GrupoController@index');
        Route::post('/grupo/registrar','GrupoController@store');
        Route::put('/grupo/actualizar','GrupoController@update');
        Route::get('/ministerio','MinisterioController@index');
        Route::post('/ministerio/registrar','MinisterioController@store');
        Route::put('/ministerio/actualizar','MinisterioController@update');
        Route::get('/visitante','VisitanteController@index');
        Route::post('/visitante/registrar','VisitanteController@store');
        Route::put('/visitante/actualizar','VisitanteController@update');
        Route::get('/slider','SliderController@index');
        Route::post('/slider/registrar','SliderController@store');
        Route::get('/usuario','UserController@index');
        Route::post('/usuario/registrar','UserController@store');
        Route::put('/usuario/actualizar','UserController@update');
        Route::get('/rol','RolController@index');
    });
    Route::group(['middleware'=>['Auxiliar']],function(){
        Route::post('/logout','Auth\LoginController@logout')->name('logout');
        Route::get('/miembro','MiembroController@index');
        Route::get('/miembro/datosMiembro','MiembroController@datosMiembro');
        Route::post('/miembro/registrar','MiembroController@store');
        Route::put('/miembro/actualizar','MiembroController@update');
        Route::post('/miembro/imagen','MiembroController@actualizarImagen');
        Route::get('/grupo','GrupoController@index');
        Route::post('/grupo/registrar','GrupoController@store');
        Route::put('/grupo/actualizar','GrupoController@update');
        Route::get('/ministerio','MinisterioController@index');
        Route::post('/ministerio/registrar','MinisterioController@store');
        Route::put('/ministerio/actualizar','MinisterioController@update');
        Route::get('/visitante','VisitanteController@index');
        Route::post('/visitante/registrar','VisitanteController@store');
        Route::put('/visitante/actualizar','VisitanteController@update');
        Route::get('/slider','SliderController@index');
        Route::post('/slider/registrar','SliderController@store');
    });
});





