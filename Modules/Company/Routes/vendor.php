<?php

Route::get('companies/{id}/edit', [
    'as' => 'vendor.companies.edit',
    'uses' => 'CompanyController@edit',
    'middleware' => 'can:vendor.company.edit',
]);

Route::put('companies/{id}', [
    'as' => 'vendor.companies.update',
    'uses' => 'CompanyController@update',
    'middleware' => 'can:vendor.company.edit',
]);
