<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'namespace' => 'Api', 'as' => 'api.v1.'], function () {
    Route::resource('positions', 'PositionsController');
    Route::resource('branches', 'BranchesController');
    Route::resource('units', 'UnitsController');
    
    Route::get('rooms/data', ['as' => 'rooms.data', 'uses' => 'RoomsController@getData']);
    Route::resource('rooms', 'RoomsController');


    Route::get('users/profile', ['as' => 'users.profile', 'uses' => 'UsersController@profile']);
    Route::get('users/data', ['as' => 'users.data', 'uses' => 'UsersController@getData']);
    Route::resource('users', 'UsersController');
    Route::post('users/update/password', ['as' => 'users.update.password', 'uses' => 'UsersController@changePassword']);

    Route::get('permissions/data', ['as' => 'permissions.data', 'uses' => 'PermissionsController@getData']);
    Route::resource('permissions', 'PermissionsController');

    Route::get('roles/data', ['as' => 'roles.data', 'uses' => 'RolesController@getData']);
    Route::resource('roles', 'RolesController');

    Route::get('locations/data', ['as' => 'locations.data', 'uses' => 'LocationsController@getData']);
    Route::resource('locations', 'LocationsController');
});
