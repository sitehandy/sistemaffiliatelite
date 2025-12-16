<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\AffiliateProgramController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\EnrollmentController;
use App\Http\Controllers\Api\Affiliate\ProgramController as AffiliateProgramsController;
use App\Http\Controllers\Api\Affiliate\TrackingLinkController;
use App\Http\Controllers\Api\Affiliate\DashboardController;
use App\Http\Controllers\Api\TrackingController;
use App\Http\Controllers\Api\Admin\CommissionController;
use App\Http\Controllers\Api\Admin\PayoutController;
use App\Http\Controllers\Api\Affiliate\CommissionController as AffiliateCommissionController;
use App\Http\Controllers\Api\Affiliate\PayoutController as AffiliatePayoutController;
use Illuminate\Support\Facades\Route;

// Public authentication routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Public tracking endpoint
Route::get('/track/{code}', [TrackingController::class, 'track']);
Route::post('/track/conversion', [TrackingController::class, 'conversion']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
        Route::get('/user', [AuthController::class, 'user']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);
        Route::put('/password', [AuthController::class, 'updatePassword']);
    });

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // Affiliate Programs
        Route::apiResource('programs', AffiliateProgramController::class);
        Route::post('programs/{program}/toggle-status', [AffiliateProgramController::class, 'toggleStatus']);

        // Products
        Route::apiResource('products', ProductController::class);
        Route::post('products/{product}/toggle-status', [ProductController::class, 'toggleStatus']);

        // Enrollments
        Route::get('enrollments', [EnrollmentController::class, 'index']);
        Route::get('enrollments/{enrollment}', [EnrollmentController::class, 'show']);
        Route::post('enrollments/{enrollment}/approve', [EnrollmentController::class, 'approve']);
        Route::post('enrollments/{enrollment}/reject', [EnrollmentController::class, 'reject']);
        Route::post('enrollments/{enrollment}/suspend', [EnrollmentController::class, 'suspend']);
        Route::post('enrollments/{enrollment}/reactivate', [EnrollmentController::class, 'reactivate']);

        // Commissions
        Route::get('commissions', [CommissionController::class, 'index']);
        Route::get('commissions/{commission}', [CommissionController::class, 'show']);
        Route::post('commissions/{commission}/approve', [CommissionController::class, 'approve']);
        Route::post('commissions/{commission}/reject', [CommissionController::class, 'reject']);

        // Payouts
        Route::get('payouts', [PayoutController::class, 'index']);
        Route::get('payouts/{payout}', [PayoutController::class, 'show']);
        Route::post('payouts/{payout}/process', [PayoutController::class, 'process']);
        Route::post('payouts/{payout}/complete', [PayoutController::class, 'complete']);
        Route::post('payouts/{payout}/fail', [PayoutController::class, 'fail']);
    });

    // Affiliate routes
    Route::middleware('role:affiliate,admin')->prefix('affiliate')->group(function () {
        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index']);
        Route::get('earnings', [DashboardController::class, 'earnings']);

        // Programs
        Route::get('programs', [AffiliateProgramsController::class, 'index']);
        Route::get('programs/{program}', [AffiliateProgramsController::class, 'show']);
        Route::post('programs/{program}/enroll', [AffiliateProgramsController::class, 'enroll']);
        Route::get('enrollments', [AffiliateProgramsController::class, 'myEnrollments']);
        Route::delete('enrollments/{enrollment}', [AffiliateProgramsController::class, 'cancelEnrollment']);

        // Tracking Links
        Route::apiResource('tracking-links', TrackingLinkController::class);
        Route::get('tracking-links/{trackingLink}/stats', [TrackingLinkController::class, 'stats']);

        // Commissions
        Route::get('commissions', [AffiliateCommissionController::class, 'index']);
        Route::get('commissions/{commission}', [AffiliateCommissionController::class, 'show']);

        // Payouts
        Route::get('payouts', [AffiliatePayoutController::class, 'index']);
        Route::post('payouts', [AffiliatePayoutController::class, 'request']);
        Route::get('payouts/{payout}', [AffiliatePayoutController::class, 'show']);

        // Payment Methods
        Route::get('payment-methods', [AffiliatePayoutController::class, 'paymentMethods']);
        Route::post('payment-methods', [AffiliatePayoutController::class, 'storePaymentMethod']);
        Route::put('payment-methods/{paymentMethod}', [AffiliatePayoutController::class, 'updatePaymentMethod']);
        Route::delete('payment-methods/{paymentMethod}', [AffiliatePayoutController::class, 'deletePaymentMethod']);
    });
});
