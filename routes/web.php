<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Support\Facades\Route;

//System Pages
Route::middleware(['auth', 'verified', 'throttle:5,1'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});
require __DIR__ . '/settings.php';

Route::view('/', 'welcome')->name('home');

// Customer Pages
Route::controller(CustomerController::class)->group(function () {
    Route::get('/faqs', 'faqs')->name('faqs');
    Route::get('/help', 'help')->name('help');
    Route::get('/support', 'support')->name('support');
    Route::get('/customers', 'index')->name('customer.index');
});



// Customer Contact
Route::post('/customers/contact', [ContactController::class, 'store'])->name('contact.store');

Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Routes
    Route::view('/', 'admin.index')->name('index');
    // Admin Category Routes
    Route::get('/category', [CategoryController::class, 'create'])->name('categories.create-category');
    Route::post('/category', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit-category');
    Route::put('/category/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    // Admin Sub Category Routes
    Route::get('/sub-category', [SubCategoryController::class, 'create'])->name('categories.create-sub-category');
    Route::post('/sub-category', [SubCategoryController::class, 'store'])->name('categories.store-sub-category');
    Route::get('/sub-category/{subCategory}/edit', [SubCategoryController::class, 'edit'])->name('categories.edit-sub-category');
    Route::put('/sub-category/{subCategory}', [SubCategoryController::class, 'update'])->name('categories.update-sub-category');
    Route::delete('/sub-category/{subCategory}', [SubCategoryController::class, 'destroy'])->name('categories.destroy-sub-category');
    // Admin Product Routes
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'create')->name('products.create-products');
        Route::post('/products', 'store')->name('products.store');
    });
    // Admin Support & Content Routes
    Route::get('/faqs', [FaqsController::class, 'index'])->name('faqs');
    Route::post('/faqs', [FaqsController::class, 'store'])->name('create-faqs');
    Route::view('/support-questions', 'admin.support-questions')->name('support-questions');
    Route::view('/support-messages', 'admin.support-messages')->name('support-messages');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::get('/banner', [BannerController::class, 'index'])->name('banner');
    Route::post('/banner', [BannerController::class, 'store'])->name('create-banner');
});
