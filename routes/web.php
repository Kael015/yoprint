<?php

use Illuminate\Support\Facades\Route;
use App\Jobs\ImportFile;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('cek-test', function(){
  
    dispatch(new ImportFile("tes-import.xlsx"));
  
    dd('done');
});
Route::get('/upload', 'SaveFileController@index');
Route::post('/proses', 'SaveFileController@proses');
Route::get('/cek', 'ProductController@import');
