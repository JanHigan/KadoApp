<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\LearnController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('collections.index');
});

// Collections
Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');
Route::get('/collections/create', [CollectionController::class, 'create'])->name('collections.create');
Route::post('/collections', [CollectionController::class, 'store'])->name('collections.store');
Route::get('/collections/{collection}', [CollectionController::class, 'show'])->name('collections.show');
Route::get('/collections/{collection}/edit', [CollectionController::class, 'edit'])->name('collections.edit');
Route::put('/collections/{collection}/update', [CollectionController::class, 'update'])->name('collections.update');
Route::delete('/collections/{collection}/destroy', [CollectionController::class, 'destroy'])->name('collections.destroy');

// Cards
Route::get('/collections/{collection}/cards/create', [CardController::class, 'create'])->name('collections.cards.create');
Route::post('/collections/{collection}/cards/store', [CardController::class, 'store'])->name('collections.cards.store');
Route::get('/collections/{collection}/cards/{card}/edit', [CardController::class, 'edit'])->name('collections.cards.edit');
Route::put('/collections/{collection}/cards/{card}/update', [CardController::class, 'update'])->name('collections.cards.update');
Route::delete('/collections/{collection}/cards/{card}/destroy', [CardController::class, 'destroy'])->name('collections.cards.destroy');

// Learn
Route::get('/collections/{collection}/learn', [LearnController::class, 'show'])->name('collections.learn');
Route::post('/collections/{collection}/cards/{card}/review', [LearnController::class, 'review'])->name('collections.cards.review');
Route::post('/collections/{collection}/learn/reset', [LearnController::class, 'reset'])->name('collections.learn.reset');
