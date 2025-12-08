<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Support\Facades\Route;

//AUTH ROUTES
Route::group(['middleware' => ['auth:web']], function () {
    
    Route::controller(AuthController::class)->group(function(){
        Route::get('/logout', 'logout');
    });

    Route::group(['middleware' => ['check-admin']], function () {
        
        Route::controller(DashboardController::class)->group(function(){
            Route::get('/dashboard', 'index');
            Route::get('/notifications', 'notifications');
            Route::get('/notifications/read/{id?}', 'readNotifications');
            Route::get('/admin/customers', 'customers');
            Route::get('/admin/orders', 'orders');
            Route::get('/admin/orders/{ref}', 'order');
            Route::post('/admin/orders/update/{id}', 'updateOrderDeliveryStatus');
        });

        Route::controller(SettingsController::class)->prefix('admin/settings')->group(function(){
            Route::get('/', 'index');
            Route::get('/sliders', 'sliders');
            Route::post('/', 'save');
        });

        Route::controller(CategoryController::class)->prefix('admin/categories')->group(function(){
            Route::get('/', 'index');
            Route::get('/create', 'create');
            Route::post('/store', 'store');
            Route::get('/edit/{id}', 'edit');
            Route::post('/edit/{id}', 'update');
            Route::get('/delete/{id}', 'delete');
        });

        Route::controller(SubCategoryController::class)->prefix('admin/sub-categories')->group(function(){
            Route::get('/', 'index');
            Route::get('/create', 'create');
            Route::post('/store', 'store');
            Route::get('/edit/{id}', 'edit');
            Route::post('/edit/{id}', 'update');
            Route::get('/delete/{id}', 'delete');
        });

        Route::controller(PackageController::class)->prefix('admin/packages')->group(function(){
            Route::get('/', 'index');
            Route::get('/create', 'create');
            Route::post('/store', 'store');
            Route::get('/edit/{id}', 'edit');
            Route::post('/edit/{id}', 'update');
            Route::get('/delete/{id}', 'delete');
            Route::get('/publish/{id}', 'publish');
            Route::get('set-layout/{type}', 'setLayout');

            Route::prefix('images')->group(function(){
                Route::get('/{id}', 'images');
                Route::post('/{id}', 'updateImages');
                Route::get('/{id}/delete', 'deleteImage');
                Route::get('/{id}/default', 'defaultImage');
            });
        });
    });
});