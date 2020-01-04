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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/','HomeController@index');

Route::get('/dodajUzytkownika','Admin\UserController@addUser');
Route::post('/saveUser','Admin\UserController@saveUser')->name('user.saveUser');
Route::get('/wszyscyUzytkownicy','Admin\UserController@allUsers')->name('user.wszyscyUzytkownicy');
Route::get('/wszyscyUzytkownicy/serach','Admin\UserController@search')->name('user.search');
Route::get('/wszyscyUzytkownicy/edycjaa/{user}','Admin\UserController@edycja')->name('user.edycjaa');
Route::post('/zapiszEdit2','Admin\UserController@saveEdit')->name('user.saveEdit2');
Route::get('/wszystkieJazdy/search','Admin\JazdyController@search')->name('jazdy.search');
Route::get('/wszystkieJazdy','Admin\JazdyController@wszystkieJazdy')->name('jazdy.wszystkieJazdy');
Route::get('/export','Admin\JazdyController@export')->name('jazdy.export');
Route::get('/wszyscyUzytkownicy/info/{kursant}','Admin\UserController@kursantInfo')->name('user.info');
Route::get('/raport','Admin\UserController@raport')->name('user.raport');
Route::get('/exportRaport','Admin\UserController@exportRaport')->name('user.exportRaport');
Route::get('/exportRaportKursant','Admin\UserController@exportRaportKursant')->name('user.exportRaportKursant');

Route::get('/wszyscyKursanci','Pracownik\UserController@allKursant')->name('user.wszyscyKursanci');
Route::get('/edycja/{user}','Pracownik\UserController@edycja')->name('user.edycja');
Route::post('/zapiszEdit','Pracownik\UserController@saveEdit')->name('user.saveEdit');
Route::get('/dodajKursant','Pracownik\UserController@addUser');
Route::post('/saveKursant','Pracownik\UserController@saveKursant')->name('user.saveKursant');
Route::get('/mojeJazdy','Pracownik\JazdyController@mojeJazdy')->name('jazdy.mojeJazdy');
Route::get('/dodajJazdy','Pracownik\JazdyController@dodajJazdy')->name('jazdy.dodajJazdy');
Route::post('/saveJazdy','Pracownik\JazdyController@saveJazdy')->name('jazdy.saveJazdy');
Route::get('/anuluj/{jazdy}','Pracownik\JazdyController@jazdyAnuluj')->name('jazdy.anuluj');
Route::get('/ok/{jazdy}','Pracownik\JazdyController@jazdyOk')->name('jazdy.ok');
Route::get('/no/{jazdy}','Pracownik\JazdyController@jazdyNo')->name('jazdy.no');

Route::get('/mojeJazdyK','Kursant\JazdyController@mojeJazdy')->name('jazdy.mojeJazdyK');
Route::get('/wolneTerminy','Kursant\JazdyController@wolneTerminy')->name('jazdy.wolneTerminy');
Route::get('/save/{jazdy}','Kursant\JazdyController@jazdySave')->name('jazdy.saveTo');
Route::get('/zrezygnuj/{jazdy}','Kursant\JazdyController@jazdyAnuluj')->name('jazdy.zrezygnuj');

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();
Route::post('/login','Auth\LoginController@authenticate');





