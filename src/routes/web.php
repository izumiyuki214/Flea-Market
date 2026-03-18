<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{item}', [ItemController::class, 'show'])->name('items.show');

Route::middleware('auth')->group(function () {
    Route::post('/item/{item}/like', [LikeController::class, 'store'])->name('likes.store');
    Route::delete('/item/{item}/like', [LikeController::class, 'destroy'])->name('likes.destroy');
    Route::post('/item/{item}/comment', [CommentController::class, 'store'])->name('comments.store');

    Route::get('/purchase/{item}', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/purchase/{item}', [PurchaseController::class, 'store'])->name('purchase.store');

    Route::get('/purchase/address/{item}', [PurchaseController::class, 'editAddress'])->name('purchase.address.edit');
    Route::put('/purchase/address/{item}', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update');

    Route::get('/sell', [SellController::class, 'create'])->name('sell.create');
    Route::post('/sell', [SellController::class, 'store'])->name('sell.store');

    Route::get('/mypage', [ProfileController::class, 'show'])->name('mypage.show');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('mypage.profile.edit');
    Route::put('/mypage/profile', [ProfileController::class, 'update'])->name('mypage.profile.update');
});