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
    Route::prefix('/user')->group(function(){
        Route::post('/login', [MemberApiController::class, 'login']);
        Route::post('/register', [MemberApiController::class, 'register']);
    });
    
    //country
    Route::get('/country', [MemberApiController::class, 'country']);
    
    // Blog
    Route::prefix('/blog')->group(function(){
        Route::get('/list', [BlogApiController::class, 'blogList']);
        Route::get('/new/post', [BlogApiController::class, 'blogNew']);
        Route::get('/detail/{id}', [BlogApiController::class, 'detail']);
        Route::get('/detail-pagination/{id}', [BlogApiController::class, 'paginationBlogDetail']);
    });
   
    
    Route::get('/rate/blog/{id}', [BlogApiController::class, 'rateBlog']);

    // Category-brand
    Route::get('/category-brand', [ProductApiController::class, 'categoryBrand']);
    // Product
    Route::get('/rate/product/{id}', [ProductApiController::class, 'getProductRate']);

    Route::prefix('/product')->group(function(){
        Route::get('/', [ProductApiController::class, 'productHome']);
        Route::get('/all', [ProductApiController::class,'productall']);
        Route::get('/new', [ProductApiController::class, 'newProduct']);
        Route::get('/sale', [ProductApiController::class, 'saleProduct']);
        Route::get('/wishlist', [ProductApiController::class, 'wishlist']);
        Route::get('/detail/{id}',[ProductApiController::class, 'productDetail']);
        Route::post('/cart',[ProductApiController::class, 'cart']);
        Route::get('/recommend',[ProductApiController::class,'productRecommend']);
        Route::get('/search',[ProductApiController::class, 'productSearch']);
        Route::get('/priceRange', [ProductApiController::class, 'productPriceRange']);
        Route::get('/searhcAdvanced', [ProductApiController::class,'productSearchAdvanced']); 
    });
  
    // send mail
    Route::post('/sendmail', [MailController::class,'send']);
    
    Route::middleware(['auth:sanctum'])->group(function(){
        Route::prefix('/product')->group(function(){
            Route::post('/comment/{id}', [ProductApiController::class, 'comment']);
            Route::post('/rate/{id}',[ProductApiController::class,'productRate']);
        });
      
        Route::prefix('/blog')->group(function(){
            Route::post('/comment/{id}', [BlogApiController::class, 'comment']);
            Route::post('/rate/{id}', [BlogApiController::class, 'createRate']);
        });

        Route::prefix('/user')->group(function(){
            Route::post('/update/{id}', [MemberApiController::class,'update']);
            Route::get('/my-product', [ProductApiController::class, 'productShow']);
            Route::post('/product/add', [ProductApiController::class, 'productAdd']);
            Route::get('/product/{id}', [ProductApiController::class, 'show']);
            Route::post('/product/update/{id}', [ProductApiController::class, 'edit']);
            Route::get('/product/delete/{id}',[ProductApiController::class, 'remove']);
        });
    });
});