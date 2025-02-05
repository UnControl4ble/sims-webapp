<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('product.index');
    });

    Route::resource('product', ProductController::class);
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('export', [ProductController::class, 'export'])->name('export');
});
