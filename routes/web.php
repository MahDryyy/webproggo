<?php

use App\Http\Controllers\GolangApiController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('login');
});
Route::get('/register', [GolangApiController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [GolangApiController::class, 'register']);
Route::get('/login', [GolangApiController::class, 'showLoginForm'])->name('login');
Route::post('/login', [GolangApiController::class, 'login']);
Route::get('/foods', [GolangApiController::class, 'getFoods']);
Route::get('/admin-dashboard', [GolangApiController::class, 'activityLogs']);
Route::get('/login-logs', [GolangApiController::class, 'getLoginLogs'])->name('loginlogs.index');
Route::post('/foods', [GolangApiController::class, 'addFood']);
Route::delete('/foods/{id}', [GolangApiController::class, 'deleteFood'])->name('foods.delete');
Route::delete('/recipes/{id}', [GolangApiController::class, 'deleteRecipe'])->name('recipes.delete');
Route::get('/recipes', [GolangApiController::class, 'getRecipes']);
Route::post('/recipe', [GolangApiController::class, 'addRecipe']);
Route::get('/dashboard', [GolangApiController::class, 'dashboard']);  
Route::get('/foods/add', function () {
    return view('foodsadd');
});
Route::get('/user', [GolangApiController::class, 'getUser']);






