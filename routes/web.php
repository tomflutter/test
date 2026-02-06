<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MasterItemsController;



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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/master-items', [App\Http\Controllers\MasterItemsController::class, 'index']);
Route::get('/master-items/search', [App\Http\Controllers\MasterItemsController::class, 'search']);
Route::get('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formView']);
Route::post('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formSubmit']);

Route::get('/master-items/view/{kode}', [App\Http\Controllers\MasterItemsController::class, 'singleView']);
Route::get('/master-items/delete/{id}', [App\Http\Controllers\MasterItemsController::class, 'delete']);


Route::get('/master-items/update-random-data', [App\Http\Controllers\MasterItemsController::class, 'updateRandomData']);


// Halaman index kategori
Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');

// Form tambah/edit kategori
Route::get('categories/form/{method}/{id?}', [CategoryController::class, 'formView'])->name('categories.form');

// Submit form
Route::post('categories/form-submit/{method}/{id?}', [CategoryController::class, 'formSubmit'])->name('categories.submit');

// Hapus kategori
Route::get('categories/delete/{id}', [CategoryController::class, 'delete'])->name('categories.delete');

// PDF kategori
Route::get('categories/pdf/{id}', [CategoryController::class, 'downloadPdf'])->name('categories.pdf');

// Excel master items
Route::get('/master-items/excel/{id}', [MasterItemsController::class, 'downloadExcelItem']);


Route::get('/master-items/pdf/{id}', [MasterItemsController::class, 'downloadPdf']);
