<?php

use App\Livewire\Faq\FaqIndex;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Livewire\ManageUser\ManageUserIndex;
use App\Http\Controllers\AccountantController;
use App\Livewire\Societies\ManageSocietiesIndex;
use App\Livewire\Members\ManageSocietiesMembersIndex;
use App\Livewire\MaintenanceBill\MaintenanceBillIndex;
use App\Livewire\MaintenanceBill\Expenses;
use App\Livewire\Societies\SocietyDetails;
use App\Http\Controllers\ZipDownloadController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\PayUMoneyController;
use App\Http\Controllers\MembersBillsController;


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

// Route::get('/download-invoice/{billId}', [BillController::class, 'downloadInvoice'])->name('download.invoice');

// Route::get('/download-receipt/{paymentId}', [BillController::class, 'downloadReceipt'])->name('download.receipt');


Route::middleware(['auth'])->group(function () {
    Route::get('/pay-bill', [BillController::class, 'showPayBillPage'])->name('show.pay.bill');
    Route::get('/download-invoice/{billId}', [BillController::class, 'downloadInvoice'])->name('download.invoice');
    // Route::post('/process-payment', [BillController::class, 'processPayment'])->name('process.payment');

    Route::get('/download-receipt/{paymentId}', [BillController::class, 'downloadReceipt'])->name('download.receipt');
    // Route::post('/accept-payment', [BillController::class, 'acceptPayment'])->name('accept.payment');
    // Route::post('payment/callback', [BillController::class, 'handlePaymentCallback'])->name('payment.callback');
});



Route::get('/pay-bill', [BillController::class, 'showPayBillPage'])->name('pay.bill');
Route::any('/process-payment', [BillController::class, 'processPayment'])->name('process.payment');
Route::match(['get', 'post'], 'payment/callback', [BillController::class, 'handlePaymentCallback'])->name('payment.callback');


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
    // Route::get('/accountant/manage/societies/{society}/society-details', SocietyDetails::class)->name('societyDetails')
    // ;

    Route::get('/accountant/manage/societies/{society}/society-details', SocietyDetails::class)
        ->name('societyDetails')
        ->middleware(['auth', 'check-role:2', 'check.subscription']);

    Route::get('/accountant/manage/societies/{society}/society-details/members', ManageSocietiesMembersIndex::class)->name('members')
        ->middleware(['auth', 'check-role:2', 'check.subscription']);;
    Route::get('/accountant/manage/societies/{society}/society-details/bills/maintenance-bill', MaintenanceBillIndex::class)->name('maintenance-bill')
        ->middleware(['auth', 'check-role:2', 'check.subscription']);;
    Route::get('/accountant/manage/societies/{society}/society-details/bills/expense', Expenses::class)->name('expense_handle')->middleware(['auth', 'check-role:2', 'check.subscription']);;  
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
