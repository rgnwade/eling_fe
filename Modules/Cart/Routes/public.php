<?php

Route::get('cart', 'CartController@index')->name('cart.index');

Route::post('cart/items', 'CartItemController@store')->name('cart.items.store');
Route::put('cart/items/{cartItemId}', 'CartItemController@update')->name('cart.items.update');
Route::delete('cart/items/{cartItemId}', 'CartItemController@destroy')->name('cart.items.destroy');
Route::get('cart/items', 'CartItemController@index')->name('cart.items.index');
Route::put('cart/items/{cartItemId}/qty', 'CartItemController@updateQty')->name('cart.items.update_qty');
Route::delete('cart/items/{cartItemId}/remove', 'CartItemController@remove')->name('cart.items.remove');

Route::post('cart/shipping-method', 'CartShippingMethodController@store')->name('cart.shipping_method.store');
Route::post('shipping/cost', 'CartShippingMethodController@shippingCost')->name('cart.shipping_method.shippingCost');
Route::post('shipping/couriers', 'CartShippingMethodController@shippingCouriers')->name('cart.shipping_method.shippingCouriers');

Route::post('payment-terms/advance', 'PaymentTermsController@setAdvance')->name('cart.payment_terms.advance');
Route::post('payment-terms/full-payment', 'PaymentTermsController@setFullPayment')->name('cart.payment_terms.full_payment');
