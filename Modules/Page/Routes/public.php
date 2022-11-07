<?php

Route::get('/', 'HomeController@index')->name('home');

Route::get('/page/news', 'HomeController@news')->name('news');
Route::get('/page/news/{slug}', 'HomeController@show')->name('news.show');
