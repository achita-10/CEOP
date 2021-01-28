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
        Route::get('/miembro/pdf/rango','MiembroController@pdfRango');
        Route::get('/miembro/pdf/dia','MiembroController@pdfDia');
        Route::get('/miembro/pdf/sinfecha','MiembroController@pdfSinFecha');
        Route::get('/miembro/pdf/individual','MiembroController@pdfindividual');
        // Route::put('/miembro/desactivar','MiembroController@desactivar');
        Route::get('/miembro/activo','MiembroController@activo');
        Route::get('/miembro/activoCampo','MiembroController@activoCampo');
        Route::post('/miembro/activoDepartamento','MiembroController@activoDepartamento');
        Route::get('/miembro/cumples','MiembroController@cumples');
        Route::get('/miembro/inactivo','MiembroController@inactivo');

        Route::get('/suspendido','SuspendidoController@index');
        Route::get('/suspendido/miembroSuspendido','SuspendidoController@miembroSuspendido');
        Route::put('/suspendido/desactivar','SuspendidoController@desactivar');
        Route::put('/suspendido/activar','SuspendidoController@activar');

        Route::get('/iglesia','IglesiaController@index');
        Route::put('/iglesia/actualizar','IglesiaController@update');
        Route::post('/asistencia/verificar','AsistenciaController@index');
        Route::post('/asistencia/guardar','AsistenciaController@store');
        Route::get('/asistencia/listarAsistencias','AsistenciaController@listarAsistencias');


        Route::get('/bautizados','MiembroController@bautizados');
        Route::get('/nobautizados','MiembroController@nobautizados');
        Route::get('/bautizos/filtrados','MiembroController@filtradoBautizos');
        Route::get('/bautizos/dia','MiembroController@diaBautizos');

        Route::get('/grupo','GrupoController@index');
        Route::get('/grupo/pdf','GrupoController@pdf');
        Route::get('/grupo/pdf/asistencia','GrupoController@pdfAsistencia');
        Route::get('/grupo/verificarAsistencia','GrupoController@verificarAsistencia');
        Route::post('/grupo/registrar','GrupoController@store');
        Route::put('/grupo/actualizar','GrupoController@update');
        Route::put('/grupo/eliminar','GrupoController@destroy');

        Route::get('/ministerio','MinisterioController@index');
        Route::get('/ministerio/pdf','MinisterioController@pdf');
        Route::post('/ministerio/registrar','MinisterioController@store');
        Route::put('/ministerio/actualizar','MinisterioController@update');
        Route::put('/ministerio/eliminar','MinisterioController@destroy');
        Route::get('/ministerio/pdf/integrantes','MiembroController@pdfIntegrantes');

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
        Route::get('/miembro','MiembroController@index');
        Route::get('/miembro/datosMiembro','MiembroController@datosMiembro');
        Route::post('/miembro/registrar','MiembroController@store');
        Route::put('/miembro/actualizar','MiembroController@update');
        Route::post('/miembro/imagen','MiembroController@actualizarImagen');
        Route::get('/miembro/pdf/rango','MiembroController@pdfRango');
        Route::get('/miembro/pdf/dia','MiembroController@pdfDia');
        Route::get('/miembro/pdf/sinfecha','MiembroController@pdfSinFecha');
        Route::put('/miembro/desactivar','MiembroController@desactivar');
        Route::get('/miembro/activo','MiembroController@activo');
        Route::get('/miembro/activoCampo','MiembroController@activoCampo');
        Route::post('/miembro/activoDepartamento','MiembroController@activoDepartamento');
        Route::get('/miembro/cumples','MiembroController@cumples');

        Route::get('/iglesia','IglesiaController@index');
        Route::put('/iglesia/actualizar','IglesiaController@update');
        Route::post('/asistencia/verificar','AsistenciaController@index');
        Route::post('/asistencia/guardar','AsistenciaController@store');
        Route::get('/asistencia/listarAsistencias','AsistenciaController@listarAsistencias');


        Route::get('/bautizados','MiembroController@bautizados');
        Route::get('/nobautizados','MiembroController@nobautizados');
        Route::get('/bautizos/filtrados','MiembroController@filtradoBautizos');
        Route::get('/bautizos/dia','MiembroController@diaBautizos');
        Route::get('/grupo','GrupoController@index');
        
        Route::post('/grupo/registrar','GrupoController@store');
        Route::put('/grupo/actualizar','GrupoController@update');
        Route::put('/grupo/eliminar','GrupoController@destroy');

        Route::get('/ministerio','MinisterioController@index');
        Route::post('/ministerio/registrar','MinisterioController@store');
        Route::put('/ministerio/actualizar','MinisterioController@update');
        Route::put('/ministerio/eliminar','MinisterioController@destroy');

        Route::get('/visitante','VisitanteController@index');
        Route::post('/visitante/registrar','VisitanteController@store');
        Route::put('/visitante/actualizar','VisitanteController@update');
        Route::get('/slider','SliderController@index');
        Route::post('/slider/registrar','SliderController@store');
    });
});





