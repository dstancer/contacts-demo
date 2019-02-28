<?php


Route::get('/', 'HomeController@index')->name('home');
Route::get('/favorites', 'HomeController@favorites')->name('favorites');
Route::get('/contact/create', 'HomeController@create')->name('create');
Route::post('/contact/store', 'HomeController@store')->name('store');
Route::get('/contact/{id}/edit', 'HomeController@edit')->name('edit');
Route::get('/contact/{id}/destroy', 'HomeController@destroy')->name('destroy');
Route::post('/contact/{id}/update', 'HomeController@update')->name('update');
Route::get('/contact/{id}/favToggle', 'HomeController@favoriteToggle')->name('favoriteToggle');
