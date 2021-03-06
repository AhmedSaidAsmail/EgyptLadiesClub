<?php
// user Auth
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
// supplier Auth
Route::get('supplier/welcome/home', ['uses' => 'Auth_Supplier\RegisterController@index'])->name('supplier.index');
Route::get('/login/supplier', 'Auth_Supplier\LoginController@showLoginForm')->name('supplier.login');
Route::post('/login/supplier', 'Auth_Supplier\LoginController@login')->name('supplier.login');
Route::get('/register/supplier', 'Auth_Supplier\RegisterController@showRegisterForm')->name('supplier.reigister');
Route::post('/register/supplier', 'Auth_Supplier\RegisterController@register')->name('supplier.register');
Route::get('/register/supplier/confirmation/{id}/{rand_code}','Auth_Supplier\RegisterController@registerConfirmation')->name('supplier.email.confirmation');
Route::post('/register/supplier/password/{id}','Auth_Supplier\RegisterController@setPassword')->name('supplier.setPassword');
Route::get('/logout/supplier', 'Auth_Supplier\LoginController@logout')->name('supplier.logout');
// Admin Area
Route::group(['prefix' => 'admin', 'middleware' => 'auth:web'], function() {
    Route::get('', ['uses' => 'Admin\HomeController@index'])->name('admin.welcome');
    Route::get('/Profile/changeDetails', ['uses' => 'Admin\ProfileController@showProfileForm'])->name('admin.change.profile');
    Route::put('/Profile/changeDetails', ['uses' => 'Admin\ProfileController@changeDetails'])->name('admin.change.profile');
    Route::resource('/filter', 'Admin\FiltersController', ['except' => ['destroy','show']]);
    Route::delete('filter/destroy', ['uses' => 'Admin\FiltersController@destroySelected'])->name('filter.destroy.selected');
    Route::resource('/sections', 'Admin\SectionsController',['except'=>['create','show','destroy']]);
    Route::resource('categories', 'Admin\CategoriesController', ['except' => [ 'show', 'destroy']]);
    Route::get('category/set/brands','Admin\CategoriesController@getCategoryBrands')->name('category.brnads');
    Route::get('section/set/brands','Admin\CategoriesController@getSectionBrands')->name('section.brnads');
    Route::resource('brands', 'Admin\BrandsController', ['except' => ['destroy', 'show']]);
    Route::delete('brands/destroy', ['uses' => 'Admin\BrandsController@destroySelected'])->name('brand.destroy.selected');
    Route::resource('/suppliers', 'Admin\SuppliersController', ['except' => ['destroy', 'create', 'store', 'edit']]);
    Route::get('/suppliers/{id}/confirm', 'Admin\SuppliersController@confirm')->name('admin.supplier.confirm');
});
// Suupliers 
Route::group(['prefix' => 'supplier', 'middleware' => 'auth:supplier'], function() {
    Route::get('', function() {
        return view('Supplier.Welcome');
    })->name('spplier.welcome');
    Route::resource('suItems','Supplier\ItemController');
    Route::get('category/filters/get','Supplier\ItemController@getFilters')->name('item.get.filters');
    Route::get('category/brands/get','Supplier\ItemController@getBrands')->name('item.get.brands');
    Route::resource('/reviews_supplier', 'Supplier\ReviewsController', ['only' => ['index', 'show']]);
});
// public Web
Route::get('','FrontEnd\HomeController@home')->name('home');
Route::get('c/{category}/{id}','FrontEnd\HomeController@categoryShow')->name('category.show');
Route::get('s/{section}/{id}}','FrontEnd\HomeController@sectionShow')->name('section.show');
