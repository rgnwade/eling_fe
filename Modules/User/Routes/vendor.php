<?php


Route::get('login', 'AuthController@getLogin')->name('vendor.login');
Route::get('', 'AuthController@getLogin')->name('vendor.login2');
Route::post('login', 'AuthController@postLogin')->name('vendor.login.post');

Route::get('logout', 'AuthController@getLogout')->name('vendor.logout');

Route::get('password/reset', 'AuthController@getReset')->name('vendor.reset');
Route::post('password/reset', 'AuthController@postReset')->name('vendor.reset.post');
Route::get('password/reset/{email}/{code}', 'AuthController@getResetComplete')->name('vendor.reset.complete');
Route::post('password/reset/{email}/{code}', 'AuthController@postResetComplete')->name('vendor.reset.complete.post');



Route::get('profile', [
    'as' => 'vendor.profile.edit',
    'uses' => 'ProfileController@edit',
]);

Route::put('profile', [
    'as' => 'vendor.profile.update',
    'uses' => 'ProfileController@update',
]);

Route::get('google2fa', 'ProfileController@getGoogle2Fa')->name('vendor.google2fa');
Route::post('google2fa', 'ProfileController@postGoogle2Fa')->name('vendor.google2fa.post');


Route::post('2fa', function () {
    return redirect(URL()->previous());
})->name('vendor.2fa')->middleware('2fa');


Route::post('users', [
    'as' => 'vendor.users.store',
    'uses' => 'UserController@store',
    'middleware' => 'can:vendor.users.create',
]);

Route::get('users/create', [
    'as' => 'vendor.users.create',
    'uses' => 'UserController@create',
    'middleware' => 'can:vendor.users.create',
]);

Route::get('users', [
    'as' => 'vendor.users.index',
    'uses' => 'UserController@index',
    'middleware' => 'can:vendor.users.index',
]);
