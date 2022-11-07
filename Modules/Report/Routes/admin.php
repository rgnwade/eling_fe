<?php

Route::get('reports_admin', [
    'as' => 'admin.reports.index',
    'uses' => 'ReportController@index',
    'middleware' => 'can:admin.reports.index',
]);
