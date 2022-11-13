<?php

Route::get('orders_admin', [
    'as' => 'admin.orders.index',
    'uses' => 'OrderController@index',
    'middleware' => 'can:admin.orders.index',
]);

Route::get('orders/{id}', [
    'as' => 'admin.orders.show',
    'uses' => 'OrderController@show',
    'middleware' => 'can:admin.orders.show',
])->where('id', '[0-9]+');;


Route::put('orders/{order}/status', [
    'as' => 'admin.orders.status.update',
    'uses' => 'OrderStatusController@update',
    'middleware' => 'can:admin.orders.edit',
]);

Route::put('orders/{order}/noResi', [
    'as' => 'admin.orders.status.updateBasic',
    'uses' => 'OrderStatusController@updateBasic',
    'middleware' => 'can:admin.orders.edit',
]);

Route::post('orders/{order}/email', [
    'as' => 'admin.orders.email.store',
    'uses' => 'OrderEmailController@store',
    'middleware' => 'can:admin.orders.show',
]);

Route::get('orders/{order}/print', [
    'as' => 'admin.orders.print.show',
    'uses' => 'OrderPrintController@show',
    'middleware' => 'can:admin.orders.show',
]);


Route::get('orders_vendor/{order_id}/{vendor_id}', [
    'as' => 'admin.orders_vendor.show',
    'uses' => 'OrderVendorController@show',
    'middleware' => 'can:admin.orders.show',
]);

Route::post('orders_vendor', [
    'as' => 'admin.orders_vendor.store',
    'uses' => 'OrderPaymentCompanyController@store',
    'middleware' => 'can:admin.orders.show',
]);

Route::delete('order_payment_vendor/{ids}', [
    'as' => 'admin.order_payment_vendor.destroy',
    'uses' => 'OrderPaymentCompanyController@destroy',
    'middleware' => 'can:admin.orders.show',
]);

Route::put('orders_payment/{id}', [
    'as' => 'admin.order_payment.update',
    'uses' => 'OrderPaymentController@update',
    'middleware' => 'can:admin.orders.edit',
]);

