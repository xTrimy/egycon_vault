<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\BelongingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HistoryController;

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


Route::get('/forms', function () {
  return view('forms');
})->name('forms');

Route::get('/tables', function () {
  return view('tables');
})->name('tables');

Route::middleware(['auth'])->group(function () {
  Route::get('/', [DashboardController::class, 'index'])->name('home');

  #Add Belonging
  Route::get('/add', [BelongingController::class, 'add'])->name('add-to-vault');
  Route::post('/add', [BelongingController::class, 'store']);

  #Edit Belonging
  Route::get('/edit/{id}', [BelongingController::class, "edit"])->name('edit');
  Route::post('/edit/{id}', [BelongingController::class, "update"]);

  #View Belonging
  Route::get('/belongings', [BelongingController::class, 'view'])->name('view');
  Route::get('/belonging/{id}', [BelongingController::class, 'belonging'])->name('belonging');
  Route::post('/belonging-image/{id}', [BelongingController::class, 'belonging_image'])->name('belonging-image');

  #View Actions History
  Route::get('/history', [HistoryController::class, 'view'])->name('history');

  #Change Belonging Status
  Route::get('/status/{id}', [BelongingController::class, 'status'])->name('status');

  #Delete Belonging
  Route::get('/delete/{id}', [BelongingController::class, 'delete'])->name('delete');


  Route::get('/slots', [SlotController::class, 'index'])->name('slots');

  Route::get('/add-slot', [SlotController::class, 'add'])->name('add-slot');
  Route::post('/add-slot', [SlotController::class, 'store']);


  Route::get('/edit-slot/{id}', [SlotController::class, "edit_slot"])->name('edit_slot');
  Route::post('/edit-slot/{id}', [SlotController::class, "update_slot"])->name('update');

  Route::get('/delete-slot/{id}', [SlotController::class, 'delete_slot'])->name('delete_slot');

  Route::get('/add-user', [UserController::class, 'add'])->name('add-user');
  Route::post('/add-user', [UserController::class, 'store']);
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
