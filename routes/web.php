<?php
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return redirect('/');
});

Route::controller(HomeController::class)->group(function(){
    Route::get('/', 'index');
    Route::get('packages', 'packages');
    Route::get('package/{slug}', 'package');
    Route::get('/about', 'about');
    Route::get('/contact', 'contact');
    Route::get('/faqs', 'faqs');
    Route::get('/terms', 'terms');
    Route::get('/privacy', 'privacy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
