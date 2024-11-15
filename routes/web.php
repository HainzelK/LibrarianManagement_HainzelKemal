<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\NewspaperController;
use App\Http\Controllers\CdController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/books', \App\Http\Controllers\BookController::class);

Route::resource('/journals', \App\Http\Controllers\JournalController::class);

Route::post('/journals/{id}/request', [JournalController::class, 'requestAccess'])->name('journals.request');
Route::post('/journals/{id}/grant', [JournalController::class, 'grantAccess'])->name('journals.grant');

Route::resource('newspapers', NewspaperController::class);
Route::post('newspapers/{id}/mark-as-stored', [NewspaperController::class, 'markAsStored'])->name('newspapers.markAsStored');




Route::resource('cds', CdController::class);
