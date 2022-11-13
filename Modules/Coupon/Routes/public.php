<?php

Route::post('cart/coupon', 'CartCouponController@store')->name('cart.coupon.store');
Route::post('cart/coupon/redeem', 'CartCouponController@redeem')->name('cart.coupon.redeem');
Route::delete('cart/coupon', 'CartCouponController@remove')->name('cart.coupon.remove');
