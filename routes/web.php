<?php

use App\Livewire\Faq\FaqIndex;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Livewire\ManageUser\ManageUserIndex;
use App\Http\Controllers\AccountantController;
use App\Livewire\Societies\ManageSocietiesIndex;
use App\Livewire\MaintenanceBill\MaintenanceBillIndex;

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


/*
|--------------------------------------------------------------------------
| Default Routes
|--------------------------------------------------------------------------
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


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/


Route::middleware(['auth', 'check-role:1'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/manage/users', ManageUserIndex::class)->name('users');
});


/*
|--------------------------------------------------------------------------
| Accountant Routes
|--------------------------------------------------------------------------
*/


Route::middleware(['auth', 'check-role:2'])->group(function () {
    Route::get('/accountant/dashboard', [AccountantController::class, 'dashboard'])->name('accountant.dashboard');
    Route::get('/accountant/manage/societies', ManageSocietiesIndex::class)->name('societies');
    Route::get('/accountant/manage/bills/maintenance-bill', MaintenanceBillIndex::class)->name('maintenance-bill');
});


/*
|--------------------------------------------------------------------------
| Normal User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'check-role:3'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});


Route::get('/faq', FaqIndex::class);

require __DIR__ . '/auth.php';
