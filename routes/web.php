<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ImportController;
use Illuminate\Support\Facades\Route;

// Show the form to upload JSON
Route::get('/import', [ImportController::class, 'showForm'])->name('import.form');
Route::get('/importFolder',function(){
    return view('import.folder');
})->name('import.fooormmm');

Route::get('/search-view',function(){
    return view('search');
});

// Fetch tables for the heightcomparison database
Route::get('/get-tables/{databaseName}', [ImportController::class, 'getTables'])->name('import.getTables');
Route::resource('blogs',BlogController::class);
Route::resource('contact', ContactController::class);
// Handle the file import process
Route::post('/import-data', [ImportController::class, 'importData'])->name('import.importData');
Route::post('/import-data-from-folder', [ImportController::class, 'importDataFromFolder'])->name('import.importDatafromfolder');