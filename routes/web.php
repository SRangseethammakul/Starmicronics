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


// Route::post('file-import', 'HomeController@fileImport')->name('file-import');
// Route::get('file-export', 'HomeController@fileExport')->name('file-export');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', 'DashboardController@index')->name('dashboard.index');
        Route::get('/getCount', 'DashboardController@getCount')->name('dashboard.getCount');
        Route::get('/showData', 'DashboardController@showData')->name('dashboard.showData');
    });

    Route::group(['middleware' => ['role:Admin']], function () {
        Route::group(['prefix' => 'usermanagement'], function () {
            Route::get('/', 'UserManagementController@index')->name('usermanagement.index');
            Route::get('/show', 'UserManagementController@show')->name('usermanagement.show');
            Route::get('/create', 'UserManagementController@create')->name('usermanagement.create');
            Route::post('/store', 'UserManagementController@store')->name('usermanagement.store');
            Route::get('/checkUser', 'UserManagementController@checkUser')->name('usermanagement.checkUser');
            Route::get('/edit/{id}', 'UserManagementController@edit')->name('usermanagement.edit');
            Route::put('/update', 'UserManagementController@update')->name('usermanagement.update');
        });
        Route::group(['prefix' => 'role'], function () {
            Route::get('/', 'RoleManagementController@index')->name('role.index');
            Route::get('/show', 'RoleManagementController@show')->name('role.show');
            Route::get('/create', 'RoleManagementController@create')->name('role.create');
            Route::post('/store', 'RoleManagementController@store')->name('role.store');
        });
    });

    Route::group(['middleware' => ['role:Admin|Staff']], function () {
        Route::post('file-import', 'AjaxController@fileImport')->name('file-import');
        Route::get('file-import-export', 'HomeController@fileImportExport')->name('export.excel');
        Route::get('file-export', 'AjaxController@fileExport')->name('file-export');
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', 'ProfileController@edit')->name('profile.edit');
        Route::post('/change-password', 'ProfileController@changePassword')->name('profile.changePassword');
    });

});
