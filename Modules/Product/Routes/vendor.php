<?php

Route::get('products', [
    'as' => 'vendor.products.index',
    'uses' => 'ProductController@index',
    'middleware' => 'can:vendor.products.index',
]);

Route::get('dasboard', [
    'as' => 'vendor.dashboard.index',
    'uses' => 'ProductController@index',
    'middleware' => 'can:vendor.products.index',
]);

Route::get('products/create', [
    'as' => 'vendor.products.create',
    'uses' => 'ProductController@create',
    'middleware' => 'can:vendor.products.create',
]);

Route::post('products', [
    'as' => 'vendor.products.store',
    'uses' => 'ProductController@store',
    'middleware' => 'can:vendor.products.create',
]);

Route::get('products/{id}/edit', [
    'as' => 'vendor.products.edit',
    'uses' => 'ProductController@edit',
    'middleware' => 'can:vendor.products.edit',
]);

Route::get('products/{id}/preview', [
    'as' => 'vendor.products.preview',
    'uses' => 'ProductController@preview',
    'middleware' => 'can:vendor.products.preview',
]);

Route::put('products/{id}', [
    'as' => 'vendor.products.update',
    'uses' => 'ProductController@update',
    'middleware' => 'can:vendor.products.edit',
]);

Route::delete('products/{ids}', [
    'as' => 'vendor.products.destroy',
    'uses' => 'ProductController@destroy',
    'middleware' => 'can:vendor.products.destroy',
]);

Route::get('products/create_videotron', [
    'as' => 'vendor.products.create_videotron',
    'uses' => 'ProductVideotronController@createVideotron',
    'middleware' => 'can:vendor.products.create_videotron',
]);


Route::post('productsVideotron', [
    'as' => 'vendor.products.store_videotron',
    'uses' => 'ProductVideotronController@storeVideotron',
    'middleware' => 'can:vendor.products.create_videotron',
]);

Route::put('productsVideotron/{id}', [
    'as' => 'vendor.products.update_videotron',
    'uses' => 'ProductVideotronController@update',
    'middleware' => 'can:vendor.products.create_videotron',
]);