<?php

use QuickRoute\Route;

Route::get('/', 'MainController@index');

Route::prefix('api')
    ->namespace('Api')
    ->group(function () {
        Route::prefix('http')
            ->namespace('Http')
            ->group(function () {
                Route::post('request', 'RequestController@request');
            });
    });