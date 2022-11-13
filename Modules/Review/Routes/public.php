<?php

Route::post('products/{productId}/reviews', 'ProductReviewController@store')->name('products.reviews.store')->middleware('auth');
Route::post('/reviews', 'ProductReviewController@save')->name('products.reviews.save')->middleware('auth');
