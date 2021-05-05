<?php

use App\Http\Controllers\Web\Back\Recipes\KategoriController;
use App\Http\Controllers\Web\Back\Recipes\RecipesController;
use App\Http\Controllers\Web\Back\Recipes\RecipesFrontController;
use App\Http\Controllers\FileUploadController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::resource('kategori', KategoriController::class);
    Route::resource('recipes', RecipesController::class);
    Route::resource('recipesFront', RecipesFrontController::class);
  
    //Route::post('add-remove-input-fields', 'RecipesController@store');

    Route::get('file-upload', [FileUploadController::class, 'index']);
    Route::post('store', [FileUploadController::class, 'store']);
});
//Route::resource('recipes/Draft', 'RecipesController@Draft');
    

	



