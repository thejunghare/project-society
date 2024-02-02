<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Livewire\ManageUser\ManageUserIndex;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\AccountantController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//developer routes
Route::middleware(['auth', 'role_id:1'])->group(function () {
Route::get('/developer/dashboard', [DeveloperController::class, 'dashboard'])->name('developer.dashboard');
});

//accountant routes
 Route::middleware(['auth', 'role_id:2'])->group(function () {
    Route::get('/accountant/dashboard', [AccountantController::class, 'dashboard'])->name('accountant.dashboard');
});

Route::get('/manage', ManageUserIndex::class);

require __DIR__ . '/auth.php';
