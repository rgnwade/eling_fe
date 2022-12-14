<?php

Route::get('login', 'AuthController@getLogin')->name('login');
Route::post('login', 'AuthController@postLogin')->name('login.post');

Route::get('autologin', 'AuthController@getAutoLogin')->name('autologin');

Route::get('login/{provider}', 'AuthController@redirectToProvider')->name('login.redirect');
Route::get('login/{provider}/callback', 'AuthController@handleProviderCallback')->name('login.callback');

Route::get('logout', 'AuthController@getLogout')->name('logout');

Route::get('register', 'AuthController@getRegister')->name('register');
Route::post('register', 'AuthController@postRegister')->name('register.post');

Route::get('register_seller', 'AuthController@getRegisterSeller')->name('register_seller');

Route::get('password/reset', 'AuthController@getReset')->name('reset');
Route::get('activate/{uuid}/{activationCode}', 'AuthController@getActivate')->name('activate');
Route::post('password/reset', 'AuthController@postReset')->name('reset.post');
Route::get('password/reset/{email}/{code}', 'AuthController@getResetComplete')->name('reset.complete');
Route::post('password/reset/{email}/{code}', 'AuthController@postResetComplete')->name('reset.complete.post');


Route::post('/api/token/validate', 'ApiTokenController@validate')->name('token.validate');
