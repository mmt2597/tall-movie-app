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

Route::get('/', function () {
    return view('welcome');
});

# Admin
Route::group([
    'as' => 'admin.',
    'prefix' => 'admin',
    'middleware' => ['auth:sanctum', 'verified', 'role:admin']
], function () {

    // Controllers
    Route::namespace('App\Http\Controllers')->group(function () {
        Route::get('/', 'AdminController@index')->name('index');
    });

    // Livewire
    Route::namespace('App\Http\Livewire')->group(function () {
        Route::get('movies', 'MovieIndex')->name('movies.index');

        Route::get('series', 'SerieIndex')->name('series.index');
        Route::get('series/{serie}/seasons', 'SeasonIndex')->name('seasons.index');
        Route::get('series/{serie}/seasons/{season}/episodes', 'EpisodeIndex')->name('episodes.index');

        Route::get('genres', 'GenreIndex')->name('genres.index');
        Route::get('casts', 'CastIndex')->name('casts.index');
        Route::get('tags', 'TagIndex')->name('tags.index');
    });
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
