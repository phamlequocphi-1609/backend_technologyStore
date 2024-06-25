<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Admin
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/admin/country/add', [CountryController::class, 'getdata']);
Route::post('/admin/country/add', [CountryController::class, 'create']);
Route::get('/admin/country/list', [CountryController::class, 'index']);
Route::get('/admin/country/delete/{id}', [CountryController::class, 'delete'])->name('countryDelete');

Route::get('/admin/profile/add', [AdminController::class, 'getCountry']);
Route::post('/admin/profile/add', [AdminController::class, 'create']);
Route::get('/admin/profile', [AdminController::class, 'profile']);
Route::post('/admin/profile', [AdminController::class, 'update']);

Route::get('/admin/blog/add', [BlogController::class, 'getData']);
Route::post('/admin/blog/add', [BlogController::class, 'create']);
Route::get('/admin/blog/list', [BlogController::class, 'index']);
Route::get('/admin/blog/edit/{id}', [BlogController::class, 'edit'])->name('blogEdit');
Route::post('/admin/blog/edit/{id}', [BlogController::class, 'update']);
Route::get('/admin/blog/delete/{id}', [BlogController::class, 'delete'])->name('blogDelete');

Route::get('/admin/category/add', [CategoryController::class, 'getCategory']);
Route::post('/admin/category/add', [CategoryController::class, 'create']);
Route::get('/admin/category/list', [CategoryController::class, 'show']);
Route::get('/admin/category/delete/{id}', [CategoryController::class, 'delete'])->name('categoryDelete');
Route::get('/admin/category/edit/{id}', [CategoryController::class, 'edit'])->name('categoryEdit');
Route::post('/admin/category/edit/{id}', [CategoryController::class, 'update']);
Route::get('/admin/brand/add', [BrandController::class, 'getBrand']);
Route::post('/admin/brand/add', [BrandController::class, 'create']);
Route::get('/admin/brand/list', [BrandController::class, 'show']);
Route::get('/admin/brand/delete/{id}', [BrandController::class, 'delete'])->name('brandDelete');