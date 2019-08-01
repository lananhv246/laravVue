<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/articles/created','ArticleController@create')->name('articles.create');
Route::get('/articles/{article}','ArticleController@edit')->name('articles.edit');
Route::get('/csv','CsvController@index')->name('csv.index');
Route::get('/csv/export', 'CsvController@export')->name('csv.export');
Route::post('/csv/import', 'CsvController@import')->name('csv.import');
Route::post('/csv/import/update', 'CsvController@update')->name('csv.update');
Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/send-new-email', 'Auth\EmailController@sendNewEmail')->name('email.send');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('uploads', 'UploadController',['except' => ['create', 'edit']]);
    Route::get('/{any}', 'SinglePageController@index')->where('any', '.*');
});


