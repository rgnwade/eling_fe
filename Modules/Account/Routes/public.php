<?php

Route::middleware('auth')->group(function () {
    Route::get('account', 'AccountDashboardController@index')->name('account.dashboard.index');

    Route::get('account/profile', 'AccountProfileController@edit')->name('account.profile.edit');
    Route::put('account/profile', 'AccountProfileController@update')->name('account.profile.update');

    Route::get('account/orders', 'AccountOrderController@index')->name('account.orders.index');
    Route::get('account/orders/{id}', 'AccountOrderController@show')->name('account.orders.show');
    Route::get('account/invoice/{id}', 'AccountOrderController@invoice')->name('account.orders.invoice');

     Route::get('account/payments', 'AccountPaymentController@index')->name('account.payments.index');

    Route::get('account/wishlist', 'AccountWishlistController@index')->name('account.wishlist.index');
    Route::delete('account/wishlist/{productId}', 'AccountWishlistController@destroy')->name('account.wishlist.destroy');

    Route::get('account/reviews', 'AccountReviewController@index')->name('account.reviews.index');

    Route::get('account/orders/{id}/reviews', 'AccountOrderController@review')->name('account.orders.review');
    Route::put('account/orders/{id}/completed', 'AccountOrderController@completed')->name('account.orders.completed');

    Route::get('account/completion', 'AccountCompletionController@index')->name('account.completion.index');
    Route::get('account/completion/show', 'AccountCompletionController@show')->name('account.completion.show');
    Route::post('account/completion', 'AccountCompletionController@save')->name('account.completion.save');
    Route::put('account/completion/{id}', 'AccountCompletionController@update')->name('account.completion.update');
    Route::post('account/completion_user', 'AccountCompletionController@saveUser')->name('account.completion.saveUser');
});
