<?php

Route::get('/','StaticPagesController@home')->name('home');
Route::get('/help','StaticPagesController@help')->name('help');
Route::get('/about','StaticPagesController@about')->name('about');

Route::get('signup','Home\UsersController@signup')->name('signup');


Route::resource('users','Home\UsersController');

Route::get('login','Home\SessionController@create')->name('login');
Route::post('login','Home\SessionController@store')->name('login');
Route::delete('logout','Home\SessionController@logout')->name('logout');