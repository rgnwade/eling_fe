<?php

Route::get('companies', [
    'as' => 'admin.companies.index',
    'uses' => 'CompanyController@index',
    'middleware' => 'can:admin.company.index',
]);

Route::get('companies/create', [
    'as' => 'admin.companies.create',
    'uses' => 'CompanyController@create',
    'middleware' => 'can:admin.company.create',
]);

Route::post('companies', [
    'as' => 'admin.companies.store',
    'uses' => 'CompanyController@store',
    'middleware' => 'can:admin.company.create',
]);

Route::get('companies/{id}/edit', [
    'as' => 'admin.companies.edit',
    'uses' => 'CompanyController@edit',
    'middleware' => 'can:admin.company.edit',
]);

Route::put('companies/{id}', [
    'as' => 'admin.companies.update',
    'uses' => 'CompanyController@update',
    'middleware' => 'can:admin.company.edit',
]);

Route::delete('companies/{ids?}', [
    'as' => 'admin.companies.destroy',
    'uses' => 'CompanyController@destroy',
    'middleware' => 'can:admin.company.destroy',
]);
