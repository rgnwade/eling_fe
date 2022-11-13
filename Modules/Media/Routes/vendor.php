<?php

Route::get('media', [
    'as' => 'vendor.media.index',
    'uses' => 'MediaController@index',
    'middleware' => 'can:vendor.media.index',
]);

Route::post('media', [
    'as' => 'vendor.media.store',
    'uses' => 'MediaController@store',
    'middleware' => 'can:vendor.media.create',
]);

Route::post('mediaFile', [
    'as' => 'vendor.media.storeFile',
    'uses' => 'MediaController@storeFile',
    'middleware' => 'can:vendor.media.create',
]);

Route::delete('media/{ids?}', [
    'as' => 'vendor.media.destroy',
    'uses' => 'MediaController@destroy',
    'middleware' => 'can:vendor.media.destroy',
]);

Route::get('file-manager', [
    'uses' => 'FileManagerController@index',
    'as' => 'vendor.file_manager.index',
    'middleware' => 'can:vendor.media.index',
]);


