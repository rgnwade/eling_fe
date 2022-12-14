<?php

Route::get('products', [
    'as' => 'admin.products.index',
    'uses' => 'ProductController@index',
    'middleware' => 'can:admin.products.index',
]);


Route::get('products_vendor', [
    'as' => 'admin.products.index_vendor',
    'uses' => 'ProductRequestController@product',
    'middleware' => 'can:admin.products.index_vendor',
]);

Route::put('products_vendor/{id}', [
    'as' => 'admin.products.update_vendor',
    'uses' => 'ProductRequestController@update',
    'middleware' => 'can:admin.products.edit_vendor',
]);

Route::get('products_vendor/{id}/edit_vendor', [
    'as' => 'admin.products.edit_vendor',
    'uses' => 'ProductRequestController@edit',
    'middleware' => 'can:admin.products.edit_vendor',
]);

Route::get('products/create', [
    'as' => 'admin.products.create',
    'uses' => 'ProductController@create',
    'middleware' => 'can:admin.products.create',
]);

Route::post('products', [
    'as' => 'admin.products.store',
    'uses' => 'ProductController@store',
    'middleware' => 'can:admin.products.create',
]);

Route::get('products/{id}/edit', [
    'as' => 'admin.products.edit',
    'uses' => 'ProductController@edit',
    'middleware' => 'can:admin.products.edit',
]);

Route::get('products/{id}/preview', [
    'as' => 'admin.products.preview',
    'uses' => 'ProductController@preview',
    'middleware' => 'can:admin.products.preview',
]);

Route::put('products/{id}', [
    'as' => 'admin.products.update',
    'uses' => 'ProductController@update',
    'middleware' => 'can:admin.products.edit',
]);

Route::delete('products/{ids}', [
    'as' => 'admin.products.destroy',
    'uses' => 'ProductController@destroy',
    'middleware' => 'can:admin.products.destroy',
]);
