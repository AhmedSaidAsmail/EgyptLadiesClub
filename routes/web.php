<?php
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::group(['prefix' => 'admin', 'middleware' => 'auth:web'], function() {
    Route::get('', ['uses' => 'Admin\HomeController@index'])->name('admin.welcome');
    Route::get('/Profile/changeDetails', ['uses' => 'Admin\ProfileController@showProfileForm'])->name('admin.change.profile');
    Route::put('/Profile/changeDetails', ['uses' => 'Admin\ProfileController@changeDetails'])->name('admin.change.profile');
    Route::resource('/filter','Admin\FiltersController',['except'=>['destroy']]);
    Route::delete('filter/destroy',['uses'=>'Admin\FiltersController@destroySelected'])->name('filter.destroy.selected');
});