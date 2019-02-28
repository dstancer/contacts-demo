<?php

use Illuminate\Http\Request;

Route::group(['prefix' => '/v1/contact', 'name' => 'api'], function () {
    Route::get('/', 'ContactController@index')->name('contact.index');
    Route::get('/favorites', 'ContactController@favorites')->name('contact.favorites');
    Route::post('/create', 'ContactController@create')->name('contact.create');
    Route::get('/{id}/phones', 'PhoneController@index')->name('phone.index');
    Route::post('/{id}/phone/{phoneId}/update', 'PhoneController@update')->name('phone.update');
    Route::get('/{id}/phone/{phoneId}/destroy', 'PhoneController@destroy')->name('phone.destroy');
    Route::post('/{id}/phone/create', 'PhoneController@create')->name('phone.create');
    Route::post('/{id}/update', 'ContactController@update')->name('contact.update');
    Route::get('/{id}/destroy', 'ContactController@destroy')->name('contact.destroy');
    Route::get('/{id}', 'ContactController@show')->name('contact.show');
});