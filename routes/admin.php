<?php

namespace App;

use Illuminate\Support\Facades\Route;

if (config('legocms.enabled.dashboard')) {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
}

Route::get('/settings', 'SettingsController@showSettings')->name('settings.show');

Route::resource('users', 'UserController');
