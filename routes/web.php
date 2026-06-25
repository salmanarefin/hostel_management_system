<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\BookingRequestController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\ExitRequestController;
use App\Http\Controllers\Admin\LeaveRequestController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\SeatChangeRequestController;
use App\Http\Controllers\Admin\SeatController;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\ExitController;
use App\Http\Controllers\Customer\LeaveController;
use App\Http\Controllers\Customer\NotificationController;
use App\Http\Controllers\Customer\RentPaymentController;
use App\Http\Controllers\Customer\SeatChangeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicHomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicHomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Dashboard Redirect Route
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'redirect'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Admin Resource Management
        |--------------------------------------------------------------------------
        */

        Route::resource('branches', BranchController::class);
        Route::resource('rooms', RoomController::class);
        Route::resource('seats', SeatController::class);
        Route::resource('announcements', AnnouncementController::class);

        /*
        |--------------------------------------------------------------------------
        | Admin Booking Request Management
        |--------------------------------------------------------------------------
        */

        Route::get('/booking-requests', [BookingRequestController::class, 'index'])
            ->name('booking-requests.index');

        Route::patch('/booking-requests/{bookingRequest}/approve', [BookingRequestController::class, 'approve'])
            ->name('booking-requests.approve');

        Route::patch('/booking-requests/{bookingRequest}/reject', [BookingRequestController::class, 'reject'])
            ->name('booking-requests.reject');

        /*
        |--------------------------------------------------------------------------
        | Admin Seat Change Request Management
        |--------------------------------------------------------------------------
        */

        Route::get('/seat-change-requests', [SeatChangeRequestController::class, 'index'])
            ->name('seat-change-requests.index');

        Route::patch('/seat-change-requests/{seatChangeRequest}/approve', [SeatChangeRequestController::class, 'approve'])
            ->name('seat-change-requests.approve');

        Route::patch('/seat-change-requests/{seatChangeRequest}/reject', [SeatChangeRequestController::class, 'reject'])
            ->name('seat-change-requests.reject');

        /*
        |--------------------------------------------------------------------------
        | Admin Payment Management
        |--------------------------------------------------------------------------
        */

        Route::get('/payments', [PaymentController::class, 'index'])
            ->name('payments.index');

        Route::patch('/payments/{payment}/approve', [PaymentController::class, 'approve'])
            ->name('payments.approve');

        Route::patch('/payments/{payment}/reject', [PaymentController::class, 'reject'])
            ->name('payments.reject');

        /*
        |--------------------------------------------------------------------------
        | Admin Leave Request Management
        |--------------------------------------------------------------------------
        */

        Route::get('/leave-requests', [LeaveRequestController::class, 'index'])
            ->name('leave-requests.index');

        Route::patch('/leave-requests/{leaveRequest}/approve', [LeaveRequestController::class, 'approve'])
            ->name('leave-requests.approve');

        Route::patch('/leave-requests/{leaveRequest}/reject', [LeaveRequestController::class, 'reject'])
            ->name('leave-requests.reject');

        /*
        |--------------------------------------------------------------------------
        | Admin Exit Request Management
        |--------------------------------------------------------------------------
        */

        Route::get('/exit-requests', [ExitRequestController::class, 'index'])
            ->name('exit-requests.index');

        Route::patch('/exit-requests/{exitRequest}/approve', [ExitRequestController::class, 'approve'])
            ->name('exit-requests.approve');

        Route::patch('/exit-requests/{exitRequest}/reject', [ExitRequestController::class, 'reject'])
            ->name('exit-requests.reject');
    });

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Customer First-Time Booking
        |--------------------------------------------------------------------------
        */

        Route::get('/bookings', [BookingController::class, 'index'])
            ->name('bookings.index');

        Route::get('/bookings/create', [BookingController::class, 'create'])
            ->name('bookings.create');

        Route::post('/bookings', [BookingController::class, 'store'])
            ->name('bookings.store');

        /*
        |--------------------------------------------------------------------------
        | Customer Seat Change
        |--------------------------------------------------------------------------
        */

        Route::get('/seat-change', [SeatChangeController::class, 'index'])
            ->name('seat-change.index');

        Route::get('/seat-change/create', [SeatChangeController::class, 'create'])
            ->name('seat-change.create');

        Route::post('/seat-change', [SeatChangeController::class, 'store'])
            ->name('seat-change.store');

        /*
        |--------------------------------------------------------------------------
        | Customer Rent and Payment
        |--------------------------------------------------------------------------
        */

        Route::get('/payments', [RentPaymentController::class, 'index'])
            ->name('payments.index');

        Route::get('/payments/create', [RentPaymentController::class, 'create'])
            ->name('payments.create');

        Route::post('/payments', [RentPaymentController::class, 'store'])
            ->name('payments.store');

        /*
        |--------------------------------------------------------------------------
        | Customer Leave Application
        |--------------------------------------------------------------------------
        */

        Route::get('/leaves', [LeaveController::class, 'index'])
            ->name('leaves.index');

        Route::get('/leaves/create', [LeaveController::class, 'create'])
            ->name('leaves.create');

        Route::post('/leaves', [LeaveController::class, 'store'])
            ->name('leaves.store');

        /*
        |--------------------------------------------------------------------------
        | Customer Exit Application
        |--------------------------------------------------------------------------
        */

        Route::get('/exits', [ExitController::class, 'index'])
            ->name('exits.index');

        Route::get('/exits/create', [ExitController::class, 'create'])
            ->name('exits.create');

        Route::post('/exits', [ExitController::class, 'store'])
            ->name('exits.store');

        /*
        |--------------------------------------------------------------------------
        | Customer Notifications
        |--------------------------------------------------------------------------
        */

        Route::get('/notifications', [NotificationController::class, 'index'])
            ->name('notifications.index');

        Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])
            ->name('notifications.unread-count');

        Route::patch('/notifications/mark-all-read/all', [NotificationController::class, 'markAllAsRead'])
            ->name('notifications.mark-all-read');

        Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
            ->name('notifications.read');
    });

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});



require __DIR__.'/auth.php';