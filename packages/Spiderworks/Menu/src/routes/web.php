<?php

Route::get('/menus/edit/{id}', 'MenusController@edit')->name('admin.menus.edit');
Route::get('/menus/destroy/{id}', 'MenusController@destroy')->name('admin.menus.destroy');
Route::get('/menus/create', 'MenusController@create')->name('admin.menus.create');
Route::post('/menus/update/{id}', 'MenusController@update')->name('admin.menus.update');
Route::post('/menus/store', 'MenusController@store')->name('admin.menus.store');
Route::post('/menus/widget', 'MenusController@widget')->name('admin.menus.widget');
Route::get('/menus/ajax', 'MenusController@selectAjax')->name('admin.menus.ajax');
Route::get('/menus/change-status/{id}/{status}', 'MenusController@changeStatus')->name('admin.menus.change-status');
Route::post('/menus/bulk-delete', 'MenusController@bulkDelete');
Route::post('/menus/bulk-enable', 'MenusController@bulkEnable');
Route::post('/menus/bulk-disable', 'MenusController@bulkDisable');
Route::get('/menus/slug-ajax', 'MenusController@checkCodeExist');
Route::get('/menus', 'MenusController@index')->name('admin.menus.index');