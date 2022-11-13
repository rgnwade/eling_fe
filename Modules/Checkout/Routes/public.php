<?php

Route::get('checkout', 'CheckoutController@create')->name('checkout.create')->middleware('auth');
Route::post('checkout', 'CheckoutController@store')->name('checkout.store')->middleware('auth');

Route::get('checkout/complete/{orderId}/{paymentGateway}', 'CheckoutCompleteController@store')->name('checkout.complete.store')->middleware('auth');
Route::get('checkout/complete', 'CheckoutCompleteController@show')->name('checkout.complete.show')->middleware('auth');

Route::get('checkout/payment-canceled/{orderId}', 'PaymentCanceledController@store')->name('checkout.payment_canceled.store');
