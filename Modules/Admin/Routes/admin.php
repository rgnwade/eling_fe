<?php

// Route::get('/', 'DashboardController@index')->name('admin.dashboard.index');
Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard.index')
->middleware('can:admin.dashboard.index');

Route::get('/sales-analytics', [
    'as' => 'admin.sales_analytics.index',
    'uses' => 'SalesAnalyticsController@index',
    'middleware' => 'can:admin.orders.index',
]);

Route::get('/', function () {
    return '';
})->name('admin.index.index');
