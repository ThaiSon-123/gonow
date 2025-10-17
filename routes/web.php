<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\clients\HomeController;
use App\Http\Controllers\clients\AboutController;
use App\Http\Controllers\clients\ToursController;
use App\Http\Controllers\clients\TourGuidesController;
use App\Http\Controllers\clients\DestinationController;
use App\Http\Controllers\clients\ContactController;
use App\Http\Controllers\clients\TourDetailController;
use App\Http\Controllers\clients\BlogController;
use App\Http\Controllers\clients\BlogDetailController;
use App\Http\Controllers\clients\LoginController;
use App\Http\Controllers\clients\LoginGoogleController;
use App\Http\Controllers\clients\SearchController;
use App\Http\Controllers\clients\UserProfileController;
use App\Http\Controllers\clients\BookingController;

// Route::get('/', function () {
//     return view('home');
// });


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/destination', [DestinationController::class, 'index'])->name('destination');
Route::get('/tour-guides', [TourGuidesController::class, 'index'])->name('tour-guides');


//Handle Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('user-login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('checkLoginClient');
Route::get('activate-account/{token}', [LoginController::class, 'activateAccount'])->name('activate.account');

//Login with google
Route::get('auth/google', [LoginGoogleController::class, 'redirectToGoogle'])->name('login-google');
Route::get('auth/google/callback', [LoginGoogleController::class, 'handleGoogleCallback']);

//Search 
Route::get('/search', [SearchController::class, 'index'])->name(name: 'search');
//Route::get('/search-voice-text', [SearchController::class, 'searchTours'])->name('search-voice-text');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/tour-detail/{id?}', [TourDetailController::class, 'index'])->name('tour-detail');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog-detail', [BlogDetailController::class, 'index'])->name('blog-detail');

//Handle Get tours , filter Tours
Route::get('/tours', [ToursController::class, 'index'])->name('tours');
Route::get('/filter-tours', [ToursController::class, 'filterTours'])->name('filter-tours');

//Handle user profile
Route::get('/user-profile', [UserProfileController::class, 'index'])->name('user-profile')->middleware('checkLoginClient');
Route::post('/user-profile', [UserProfileController::class, 'update'])->name('update-user-profile');
Route::post('/change-password-profile', [UserProfileController::class, 'changePassword'])->name('change-password');
Route::post('/change-avatar-profile', [UserProfileController::class, 'changeAvatar'])->name('change-avatar');

//Hanlde checkout
Route::post('/booking/{id?}', [BookingController::class, 'index'])->name('booking')->middleware('checkLoginClient');
Route::post('/create-booking', [BookingController::class, 'createBooking'])->name('create-booking');
//Route::get('/booking', [BookingController::class, 'handlePaymentMomoCallback'])->name('handlePaymentMomoCallback');

// Handle 404 for admin and client
Route::fallback(function () {
    if (request()->is('admin/*')) {
        return response()->view('admin.errors.404', [], 404);
    }
    return response()->view('clients.errors.404', ['title' => '404'], 404);
});