<?php

// Route::get('countries/{code}/states', 'CountryStateController@index')->name('countries.states.index');
Route::post('states', 'CountryStateController@states')->name('countries.states.states');
Route::post('cities', 'CountryStateController@cities')->name('countries.states.cities');
Route::post('districts', 'CountryStateController@districts')->name('countries.states.districts');
Route::post('resi', 'CountryStateController@resi')->name('countries.states.resi');
