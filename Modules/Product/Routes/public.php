<?php

Route::get('products', 'ProductController@index')->name('products.index');
Route::get('products/{slug}', 'ProductController@show')->name('products.show');
Route::get('merchants/{slug}', 'MerchantController@index')->name('merchants.index')->middleware('auth');
Route::get('recent-products', 'RecentProductController@index')->name('recent_products.index');
