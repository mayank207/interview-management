<?php

use Illuminate\Support\Facades\Route;

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

Route::redirect('/','/login');

Auth::routes(['register'=>false]);

Route::group(['middleware' => 'customauth'], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('search/student','HomeController@searchstudent')->name('student.search');
    Route::middleware('can:create-hr')->group(function(){
        // HR Routes
        Route::resource('hr', 'HrController')->only(['index','create','store','edit','update','destroy']);
        Route::post('hr/search', 'HrController@searchhr')->name('hr.search');
    });

    // Notes routes
    Route::resource('notes', 'NotesController')->only(['index','create','store','edit','update','destroy']);
    Route::post('notes/favourite','NotesController@notefavourite')->name('note.favourite');
    // Search note routes
    Route::post('note/search','NotesController@searchnote')->name('note.search');

    // Policy Routes
    // Route::get('getpolicy','HomeController@getpolicy')->name('get.policy');
    Route::post('updatepolicy/{id}','HomeController@updatepolicy')->name('update.policy');
    Route::post('savepolicy','HomeController@store')->name('save.policy');

    // Recruting Routes
    Route::resource('recrut','RecrutingController')->only(['index','store','show','destroy']);
    Route::post('stateupdate','RecrutingController@updateOrder')->name('recrut.updatestate');

    // Job Routes
    Route::resource('job', 'JobsController')->only(['index','create','store','edit','update','destroy']);;
    // Search Job Routes
    Route::post('job/search', 'JobsController@searchjob')->name('job.search');


});
