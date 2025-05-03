<?php

use App\Http\Controllers\GolangApiController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return redirect('/login');
});
Route::get('/register', [GolangApiController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [GolangApiController::class, 'register']);
Route::get('/login', [GolangApiController::class, 'showLoginForm'])->name('login');
Route::post('/login', [GolangApiController::class, 'login']);
Route::get('/foods', [GolangApiController::class, 'getFoods']);
Route::post('/foods', [GolangApiController::class, 'addFood']);
Route::delete('/foods/{id}', [GolangApiController::class, 'deleteFood']);
Route::get('/recipes', [GolangApiController::class, 'getRecipes']);
Route::post('/recipe', [GolangApiController::class, 'addRecipe']);  
Route::get('/foods/add', function () {
    return view('foodsadd');
});






