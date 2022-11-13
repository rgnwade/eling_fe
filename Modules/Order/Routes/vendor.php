<?php

Route::get('orders', [
    'as' => 'vendor.orders.index',
    'uses' => 'OrderController@index',
    'middleware' => 'can:vendor.orders.index',
])->where('id', '[0-9]+');;

Route::get('orders/{id}', [
    'as' => 'vendor.orders.show',
    'uses' => 'OrderController@show',
    'middleware' => 'can:vendor.orders.show',
])->where('id', '[0-9]+');;

Route::put('orders/{id}', [
    'as' => 'vendor.orders.update',
    'uses' => 'OrderController@update',
    'middleware' => 'can:vendor.orders.edit',
]);

Route::get('/', 'OrderController@index')->name('admin.order.index2')
->middleware('can:vendor.orders.index');

