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

Route::middleware('auth')->get('/', function () {
    return redirect(route('projects.index'));
})->name('home');

Route::middleware(['auth', 'members.only'])->prefix('projects')->name('projects.')->group(function() {

    Route::get('', 'ProjectsController@index')->name('index');

    Route::post('', 'ProjectsController@store')->withoutMiddleware('members.only')->name('store');

    Route::prefix('{project}')->group(function() {

        Route::get('', 'ProjectsController@show')->name('show');

        Route::delete('', 'ProjectsController@destroy')->name('destroy');

        Route::prefix('team')->name('team.')->group(function() {

            Route::get('', 'TeamsController@show')->name('show');

            Route::get('join', 'TeamsController@join')->withoutMiddleware(['auth', 'members.only'])->name('join');

            Route::post('invite', 'TeamsController@sendInvitationEmail')->name('invite');

            Route::delete('remove', 'TeamsController@remove')->name('remove');
        });

        Route::prefix('folders/{folder}')->name('folders.')->group(function() {

            Route::get('', 'FoldersController@show')->name('show');

            Route::post('', 'FoldersController@store')->name('store');

            Route::delete('delete', 'FoldersController@destroy')->name('destroy');
        });
    });
});

Route::middleware('auth')->prefix('files')->name('files.')->group(function() {
    
    Route::post('presigned-url', 'FilesController@presignedUrl')->name('presignedUrl');

    Route::prefix('{file}')->group(function() {

        Route::get('download', 'FilesController@download')->name('download');

        Route::get('actions', 'FilesController@actions')->name('actions');

        Route::patch('', 'FilesController@update')->name('update');

        Route::delete('', 'FilesController@destroy')->name('destroy');

        Route::prefix('support-data')->name('support-data.')->group(function() {

            Route::post('', 'SupportDataController@store')->name('store');

            Route::delete('{supportData}', 'SupportDataController@destroy')->name('destroy');

        });

    });

    Route::prefix('{revision}')->group(function() {

        Route::get('', 'FilesController@show')->name('show');

        Route::get('dropzone', 'FilesController@dropzone')->name('dropzone');

        Route::get('exists', 'FilesController@exists')->name('exists');
        
        Route::post('', 'FilesController@store')->name('store');
    });
});


Route::middleware('auth')->prefix('revisions')->name('revisions.')->group(function() {

    Route::post('{folder}', 'RevisionsController@increment')->name('increment');

    Route::delete('{revision}', 'RevisionsController@destroy')->name('destroy');

});

Route::middleware('auth')->prefix('comments')->name('comments.')->group(function() {

    Route::get('', 'CommentsController@index')->name('index');

    Route::get('comment', 'CommentsController@show')->name('show');

    Route::patch('read', 'CommentsController@read')->name('read');

    Route::post('{project}', 'CommentsController@store')->name('store');

    Route::delete('{comment}', 'CommentsController@destroy')->name('destroy');

});