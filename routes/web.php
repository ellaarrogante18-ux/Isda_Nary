<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FishController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ExpenseController;

// Welcome/Get Started Page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Fish Inventory Routes
    Route::resource('fish', FishController::class);
    Route::post('/fish/{fish}/add-stock', [FishController::class, 'addStock'])->name('fish.add-stock');
    
    // Sales Routes
    Route::resource('sales', SaleController::class);
    Route::get('/fish/{fish}/price', [SaleController::class, 'getFishPrice'])->name('fish.price');
    
    // Expenses Routes
    Route::resource('expenses', ExpenseController::class);
});

// Redirect root to welcome if not authenticated
Route::redirect('/home', '/dashboard');
