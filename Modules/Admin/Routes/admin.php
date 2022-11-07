<?php

// Route::get('/', 'DashboardController@index')->name('admin.dashboard.index');
Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard.index');
// ->middleware('2fa');

Route::get('/sales-analytics', [
    'as' => 'admin.sales_analytics.index',
    'uses' => 'SalesAnalyticsController@index',
    'middleware' => 'can:admin.orders.index',
]);
