<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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

Route::get('/', [ListingController::class, 'index']);
//create
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');
// Store data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');
// edit Data
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');
// Update Listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');
// Delete Listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//Manage Listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

// single list
Route::get('/listings/{listing}', [ListingController::class, 'show']);

//Show Register  Create From
Route::get('/register', [UserController::class, 'create'])->middleware('guest');
//Create New User
Route::post('/users', [UserController::class, 'store']);
//Logout user
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');
//Logout user
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
//Login user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);
