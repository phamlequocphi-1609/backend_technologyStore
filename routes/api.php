<?php

use App\Http\Controllers\Api\BlogApiController;
use App\Http\Controllers\Api\MemberApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'namespace'=>'Api'
], function(){
    // member
    Route::post('/user/login', [MemberApiController::class, 'login']);
    Route::post('/user/register', [MemberApiController::class, 'register']);
    Route::get('/country', [MemberApiController::class, 'country']);
    // Blog
    Route::get('/blog/list', [BlogApiController::class, 'blogList']);
    Route::get('/blog/new/post', [BlogApiController::class, 'blogNew']);
    Route::get('/blog/detail/{id}', [BlogApiController::class, 'detail']);
    Route::get('/rate/blog/{id}', [BlogApiController::class, 'rateBlog']);
    Route::get('/blog/detail-pagination/{id}', [BlogApiController::class, 'paginationBlogDetail']);
    // Category-brand
    Route::get('/category-brand', [ProductApiController::class, 'categoryBrand']);
    // Product
    Route::get('/rate/product/{id}', [ProductApiController::class, 'getProductRate']);
    Route::get('/product', [ProductApiController::class, 'productHome']);
    Route::get('/product/all', [ProductApiController::class,'productall']);
    Route::get('/product/new', [ProductApiController::class, 'newProduct']);
    Route::get('/product/sale', [ProductApiController::class, 'saleProduct']);
    Route::get('/product/wishlist', [ProductApiController::class, 'wishlist']);
    Route::get('/product/detail/{id}',[ProductApiController::class, 'productDetail']);
    Route::post('/product/cart',[ProductApiController::class, 'cart']);
    Route::get('/product/recommend',[ProductApiController::class,'productRecommend']);
    Route::get('/product/search',[ProductApiController::class, 'productSearch']);
    Route::get('/product/priceRange', [ProductApiController::class, 'productPriceRange']);
    Route::get('/product/searhcAdvanced', [ProductApiController::class,'productSearchAdvanced']); 
    // send mail
    Route::post('/sendmail', [MailController::class,'send']);
    
    Route::middleware(['auth:sanctum'])->group(function(){
        Route::post('/product/comment/{id}', [ProductApiController::class, 'comment']);
        Route::post('/blog/comment/{id}', [BlogApiController::class, 'comment']);
        Route::post('/blog/rate/{id}', [BlogApiController::class, 'createRate']);
        Route::post('/user/update/{id}', [MemberApiController::class,'update']);
        Route::get('/user/my-product', [ProductApiController::class, 'productShow']);
        Route::post('/user/product/add', [ProductApiController::class, 'productAdd']);
        Route::get('/user/product/{id}', [ProductApiController::class, 'show']);
        Route::post('/user/product/update/{id}', [ProductApiController::class, 'edit']);
        Route::get('/user/product/delete/{id}',[ProductApiController::class, 'remove']);
        Route::post('/product/rate/{id}',[ProductApiController::class,'productRate']);
    });
});