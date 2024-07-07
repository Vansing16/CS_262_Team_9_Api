<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\CustomerController;

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
    if (Auth::check()) {
        return redirect('/dashboard'); // Redirect authenticated users to the dashboard
    } else {
        return view('auth.login'); // Show the login view for unauthenticated users
    }
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // Show the dashboard view for authenticated and verified users
    })->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    });    

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Customer Routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.dashboard');
    Route::get('/customer/ticket', [CustomerController::class, 'showTicket'])->name('customer.ticket');
    Route::get('/customer/ticket/create', [CustomerController::class, 'createTicket'])->name('customer.create-ticket');
    Route::post('/customer/ticket/store', [CustomerController::class, 'storeTicket'])->name('customer.store-ticket');
    Route::get('/customer/ticket/{ticketId}', [CustomerController::class, 'viewTicket'])->name('customer.view-ticket');
    Route::get('/customer/settings', [CustomerController::class, 'editSettings'])->name('customer.setting');
    Route::post('/customer/settings', [CustomerController::class, 'updateSettings'])->name('customer.update-settings');
    Route::get('/customer/messages', [CustomerController::class, 'message'])->name('customer.message');
    Route::get('/customer/messages/{messageId}', [CustomerController::class, 'viewMessage'])->name('customer.view-message');
    Route::post('/customer/messages/send', [CustomerController::class, 'sendMessage'])->name('customer.send-message');
    Route::get('/customer/send-feedback/{ticketId}', [CustomerController::class, 'sendFeedback'])->name('customer.send-feedback');
    Route::post('/customer/send-feedback/{ticketId}', [CustomerController::class, 'postFeedback'])->name('customer.post-feedback');
});

// Technician Routes
Route::middleware(['auth', 'role:technician'])->group(function () {
    Route::get('/technician', [TechnicianController::class, 'index'])->name('technician.dashboard');
    Route::get('/technician/ticket', [TechnicianController::class, 'showTechnicianTickets'])->name('technician.tickets');
    Route::get('/technician/ticket/{ticketId}', [TechnicianController::class, 'viewTicket'])->name('technician.view-ticket');
    Route::get('/technician/messages', [TechnicianController::class, 'message'])->name('technician.message');
    Route::get('/technician/settings', [TechnicianController::class, 'editSettings'])->name('technician.setting');
    Route::post('/technician/settings', [TechnicianController::class, 'updateSettings'])->name('technician.update-settings');
    Route::get('/technician/messages/{messageId}', [TechnicianController::class, 'viewMessage'])->name('technician.view-message');
    Route::get('/technician/messages/create/{ticketId}', [TechnicianController::class, 'createMessage'])->name('technician.create-message');
    Route::post('/technician/messages/store', [TechnicianController::class, 'storeMessage'])->name('technician.store-message');
    Route::delete('/technician/messages/{messageId}', [TechnicianController::class, 'deleteMessage'])->name('technician.delete-message');
    Route::put('/technician/tickets/{ticketId}/update-status', [TechnicianController::class, 'updateTicketStatus'])
        ->name('technician.update-ticket-status');
});

// Include Laravel's authentication routes
require __DIR__.'/auth.php';
