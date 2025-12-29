<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Api\TrackingController;
use App\Http\Controllers\Web\Admin\PayoutController as AdminPayoutController;
use App\Http\Controllers\Web\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Web\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Web\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Web\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Web\Admin\UpgradeController as AdminUpgradeController;
use App\Http\Controllers\Web\Affiliate\LinkController as AffiliateLinkController;
use App\Http\Controllers\Web\Admin\AffiliateController as AdminAffiliateController;
use App\Http\Controllers\Web\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Web\Admin\CommissionController as AdminCommissionController;
use App\Http\Controllers\Web\Admin\EnrollmentController as AdminEnrollmentController;
use App\Http\Controllers\Web\Affiliate\PayoutController as AffiliatePayoutController;
use App\Http\Controllers\Web\Admin\EnvSettingsController as AdminEnvSettingsController;
use App\Http\Controllers\Web\Affiliate\ProgramController as AffiliateProgramController;
use App\Http\Controllers\Web\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Web\Affiliate\DashboardController as AffiliateDashboardController;
use App\Http\Controllers\Web\Affiliate\CommissionController as AffiliateCommissionController;
use App\Http\Controllers\Web\Admin\IntegrationGuideController as AdminIntegrationGuideController;

// Installation routes
Route::prefix('install')->group(function () {
    Route::get('/', [InstallController::class, 'index'])->name('install.index');
    Route::get('/requirements', [InstallController::class, 'checkRequirements'])->name('install.requirements');
    Route::post('/database/test', [InstallController::class, 'testDatabase'])->name('install.database.test');
    Route::post('/environment', [InstallController::class, 'saveEnvironment'])->name('install.environment');
    Route::post('/migrations', [InstallController::class, 'runMigrations'])->name('install.migrations');
    Route::post('/admin', [InstallController::class, 'createAdmin'])->name('install.admin');
    Route::post('/email/test', [InstallController::class, 'testEmail'])->name('install.email.test');
    Route::post('/finalize', [InstallController::class, 'finalize'])->name('install.finalize');
});

// Tracking route (public)
Route::get('/track/{code}', [TrackingController::class, 'track'])->name('track');

// Home route
Route::get('/', function () {
    if (!file_exists(storage_path('installed'))) {
        return redirect()->route('install.index');
    }
    if (auth()->check()) {
        if (auth()->user()->role?->name === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('affiliate.dashboard');
    }
    return redirect()->route('login');
})->name('home');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard redirect
    Route::get('/dashboard', function () {
        if (auth()->user()->role?->name === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('affiliate.dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->middleware('demo_mode')->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->middleware('demo_mode')->name('profile.password');

    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Programs
        Route::resource('programs', AdminProgramController::class);
        Route::post('programs/{program}/toggle-status', [AdminProgramController::class, 'toggleStatus'])->name('programs.toggle-status');

        // Products
        Route::resource('products', AdminProductController::class);
        Route::post('products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');
        Route::delete('products/{product}/images/{index}', [AdminProductController::class, 'deleteImage'])->name('products.delete-image');

        // Affiliates
        Route::get('affiliates', [AdminAffiliateController::class, 'index'])->name('affiliates.index');
        Route::get('affiliates/{affiliate}', [AdminAffiliateController::class, 'show'])->name('affiliates.show');
        Route::get('affiliates/{affiliate}/edit', [AdminAffiliateController::class, 'edit'])->name('affiliates.edit');
        Route::put('affiliates/{affiliate}', [AdminAffiliateController::class, 'update'])->name('affiliates.update');
        Route::post('affiliates/{affiliate}/toggle-status', [AdminAffiliateController::class, 'toggleStatus'])->name('affiliates.toggle-status');
        Route::post('affiliates/{affiliate}/reset-password', [AdminAffiliateController::class, 'resetPassword'])->name('affiliates.reset-password');
        Route::delete('affiliates/{affiliate}', [AdminAffiliateController::class, 'destroy'])->name('affiliates.destroy');
        // Affiliate Payment Methods
        Route::get('affiliates/{affiliate}/payment-methods/create', [AdminAffiliateController::class, 'createPaymentMethod'])->name('affiliates.payment-methods.create');
        Route::post('affiliates/{affiliate}/payment-methods', [AdminAffiliateController::class, 'storePaymentMethod'])->name('affiliates.payment-methods.store');
        Route::get('affiliates/{affiliate}/payment-methods/{paymentMethod}/edit', [AdminAffiliateController::class, 'editPaymentMethod'])->name('affiliates.payment-methods.edit');
        Route::put('affiliates/{affiliate}/payment-methods/{paymentMethod}', [AdminAffiliateController::class, 'updatePaymentMethod'])->name('affiliates.payment-methods.update');
        Route::delete('affiliates/{affiliate}/payment-methods/{paymentMethod}', [AdminAffiliateController::class, 'destroyPaymentMethod'])->name('affiliates.payment-methods.destroy');

        // Enrollments
        Route::get('enrollments', [AdminEnrollmentController::class, 'index'])->name('enrollments.index');
        Route::get('enrollments/{enrollment}', [AdminEnrollmentController::class, 'show'])->name('enrollments.show');
        Route::post('enrollments/{enrollment}/approve', [AdminEnrollmentController::class, 'approve'])->name('enrollments.approve');
        Route::post('enrollments/{enrollment}/reject', [AdminEnrollmentController::class, 'reject'])->name('enrollments.reject');
        Route::post('enrollments/{enrollment}/suspend', [AdminEnrollmentController::class, 'suspend'])->name('enrollments.suspend');
        Route::post('enrollments/{enrollment}/reactivate', [AdminEnrollmentController::class, 'reactivate'])->name('enrollments.reactivate');

        // Commissions
        Route::get('commissions', [AdminCommissionController::class, 'index'])->name('commissions.index');
        Route::get('commissions/{commission}', [AdminCommissionController::class, 'show'])->name('commissions.show');
        Route::post('commissions/{commission}/approve', [AdminCommissionController::class, 'approve'])->name('commissions.approve');
        Route::post('commissions/{commission}/reject', [AdminCommissionController::class, 'reject'])->name('commissions.reject');
        Route::post('commissions/bulk-approve', [AdminCommissionController::class, 'bulkApprove'])->name('commissions.bulk-approve');

        // Payouts
        Route::get('payouts', [AdminPayoutController::class, 'index'])->name('payouts.index');
        Route::get('payouts/{payout}', [AdminPayoutController::class, 'show'])->name('payouts.show');
        Route::post('payouts/{payout}/process', [AdminPayoutController::class, 'process'])->name('payouts.process');
        Route::post('payouts/{payout}/complete', [AdminPayoutController::class, 'complete'])->name('payouts.complete');
        Route::post('payouts/{payout}/fail', [AdminPayoutController::class, 'fail'])->name('payouts.fail');
        Route::post('payouts/{payout}/cancel', [AdminPayoutController::class, 'cancel'])->name('payouts.cancel');

        // Reports
        Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
        Route::get('reports/overview', [AdminReportController::class, 'overview'])->name('reports.overview');
        Route::get('reports/affiliates', [AdminReportController::class, 'affiliates'])->name('reports.affiliates');
        Route::get('reports/programs', [AdminReportController::class, 'programs'])->name('reports.programs');
        Route::get('reports/products', [AdminReportController::class, 'products'])->name('reports.products');
        Route::get('reports/export', [AdminReportController::class, 'export'])->name('reports.export');

        // Settings
        Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [AdminSettingController::class, 'update'])->middleware('demo_mode')->name('settings.update');

        // Mail Settings
        Route::get('settings/mail', [AdminEnvSettingsController::class, 'mailSettings'])->name('settings.mail');
        Route::put('settings/mail', [AdminEnvSettingsController::class, 'updateMailSettings'])->middleware('demo_mode')->name('settings.mail.update');
        Route::post('settings/mail/test', [AdminEnvSettingsController::class, 'testMail'])->middleware('demo_mode')->name('settings.mail.test');

        // App Settings
        Route::get('settings/app', [AdminEnvSettingsController::class, 'appSettings'])->name('settings.app');
        Route::put('settings/app', [AdminEnvSettingsController::class, 'updateAppSettings'])->middleware('demo_mode')->name('settings.app.update');

        // Announcements
        Route::get('announcements', [AdminAnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('announcements/create', [AdminAnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('announcements', [AdminAnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('announcements/{announcement}/edit', [AdminAnnouncementController::class, 'edit'])->name('announcements.edit');
        Route::put('announcements/{announcement}', [AdminAnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('announcements/{announcement}', [AdminAnnouncementController::class, 'destroy'])->name('announcements.destroy');
        Route::post('announcements/{announcement}/toggle-status', [AdminAnnouncementController::class, 'toggleStatus'])->name('announcements.toggle-status');

        // Integration Guide
        Route::get('integration-guide', [AdminIntegrationGuideController::class, 'index'])->name('integration-guide.index');

        // System Upgrade
        Route::get('upgrade', [AdminUpgradeController::class, 'index'])->name('upgrade.index');
        Route::get('upgrade/check', [AdminUpgradeController::class, 'check'])->name('upgrade.check');
        Route::post('upgrade/run', [AdminUpgradeController::class, 'run'])->middleware('demo_mode')->name('upgrade.run');
        Route::post('upgrade/migrate', [AdminUpgradeController::class, 'migrate'])->middleware('demo_mode')->name('upgrade.migrate');
        Route::post('upgrade/clear-cache', [AdminUpgradeController::class, 'clearCache'])->name('upgrade.clear-cache');
    });

    // Affiliate routes
    Route::prefix('affiliate')->name('affiliate.')->middleware('role:affiliate')->group(function () {
        Route::get('/', [AffiliateDashboardController::class, 'index'])->name('dashboard');

        // Programs
        Route::get('programs', [AffiliateProgramController::class, 'index'])->name('programs.index');
        Route::get('programs/enrolled', [AffiliateProgramController::class, 'enrolled'])->name('programs.enrolled');
        Route::get('programs/{program}', [AffiliateProgramController::class, 'show'])->name('programs.show');
        Route::post('programs/{program}/enroll', [AffiliateProgramController::class, 'enroll'])->name('programs.enroll');
        Route::post('programs/{program}/leave', [AffiliateProgramController::class, 'leave'])->name('programs.leave');
        Route::post('programs/join-with-code', [AffiliateProgramController::class, 'joinWithCode'])->name('programs.join-with-code');

        // Links
        Route::get('links', [AffiliateLinkController::class, 'index'])->name('links.index');
        Route::get('links/create', [AffiliateLinkController::class, 'create'])->name('links.create');
        Route::post('links', [AffiliateLinkController::class, 'store'])->name('links.store');
        Route::get('links/{link}', [AffiliateLinkController::class, 'show'])->name('links.show');
        Route::delete('links/{link}', [AffiliateLinkController::class, 'destroy'])->name('links.destroy');

        // Commissions
        Route::get('commissions', [AffiliateCommissionController::class, 'index'])->name('commissions.index');
        Route::get('commissions/{commission}', [AffiliateCommissionController::class, 'show'])->name('commissions.show');

        // Payouts
        Route::get('payouts', [AffiliatePayoutController::class, 'index'])->name('payouts.index');
        Route::post('payouts/request', [AffiliatePayoutController::class, 'request'])->name('payouts.request');
        Route::get('payouts/{payout}', [AffiliatePayoutController::class, 'show'])->name('payouts.show');
        Route::post('payouts/{payout}/cancel', [AffiliatePayoutController::class, 'cancel'])->name('payouts.cancel');

        // Payment Methods
        Route::get('payment-methods', [AffiliatePayoutController::class, 'paymentMethods'])->name('payment-methods.index');
        Route::post('payment-methods', [AffiliatePayoutController::class, 'storePaymentMethod'])->name('payment-methods.store');
        Route::put('payment-methods/{paymentMethod}', [AffiliatePayoutController::class, 'updatePaymentMethod'])->name('payment-methods.update');
        Route::delete('payment-methods/{paymentMethod}', [AffiliatePayoutController::class, 'deletePaymentMethod'])->name('payment-methods.destroy');
    });
});



Route::get('/artisan/migrate', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Migrations run successfully.';
})->name('artisan.migrate');
