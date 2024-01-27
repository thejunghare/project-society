<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DevController;
use App\Http\Controllers\AuditorController;
use App\Http\Controllers\AccountantController;

use Illuminate\Support\Facades\Route;

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

//dev routes
Route::middleware(['auth','role:dev'])->group(function () {
    Route::get('/dev/dashboard',[DevController::class,'dashboard'])->name('dev.dashboard');
    //show count
    Route::get('/dev/dashboard', [DevController::class,'userCount'])->name('dev.dashboard');
    //see user
    Route::get('/dev/manage/', [DevController::class, 'user'])->name('dev.show');
    //destory user
    Route::delete('/dev/destory/{user}', [DevController::class, 'destory'])->name('user.destory');
});

//auditor routes
Route::middleware(['auth','role:auditor'])->group(function () {
    Route::get('/auditor/dashboard',[AuditorController::class,'dashboard'])->name('auditor.dashboard');
});

//accountant routes
Route::middleware(['auth','role:accountant'])->group(function () {
    Route::get('/accountant/dashboard',[AccountantController::class,'dashboard'])->name('accountant.dashboard');
});

require __DIR__.'/auth.php';
