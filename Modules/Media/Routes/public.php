<?php

Route::post('media/', 'MediaController@store')->name('media.store');
Route::post('mediafile/', 'MediaController@storeFile')->name('media.storeFile');
Route::delete('media/{id}', 'MediaController@destroy')->name('media.destroy');
