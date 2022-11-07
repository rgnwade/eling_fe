<?php

Route::get('cart', 'CartController@index')->name('cart.index');

Route::post('cart/items', 'CartItemController@store')->name('cart.items.store');
Route::put('cart/items/{cartItemId}', 'CartItemController@update')->name('cart.items.update');
Route::delete('cart/items/{cartItemId}', 'CartItemController@destroy')->name('cart.items.destroy');

Route::post('cart/shipping-method', 'CartShippingMethodController@store')->name('cart.shipping_method.store');
Route::post('shipping/cost', 'CartShippingMethodController@shippingCost')->name('cart.shipping_method.shippingCost');
Route::post('shipping/couriers', 'CartShippingMethodController@shippingCouriers')->name('cart.shipping_method.shippingCouriers');