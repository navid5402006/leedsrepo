<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\FeePaymentController;
use App\Http\Controllers\Admin\StudentCardController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TalentTestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest routes (accessible only when not logged in)
Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
});

// Authenticated routes (accessible only when logged in)
Route::middleware('auth:admin')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // =============================================
    // 1. STUDENTS MANAGEMENT
    // =============================================
   // routes/web.php - Add these routes inside students group

Route::prefix('admin/students')->name('admin.students.')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('index');
    Route::get('/create', [StudentController::class, 'create'])->name('create');
    Route::post('/store', [StudentController::class, 'store'])->name('store');
    Route::get('/{id}', [StudentController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [StudentController::class, 'edit'])->name('edit');
    Route::put('/{id}', [StudentController::class, 'update'])->name('update');
    Route::delete('/{id}', [StudentController::class, 'destroy'])->name('destroy');
    
    // Additional routes for soft delete management
    Route::delete('/{id}/soft', [StudentController::class, 'softDelete'])->name('soft-delete');
    Route::post('/{id}/restore', [StudentController::class, 'restore'])->name('restore');
    Route::get('/stats', [StudentController::class, 'stats'])->name('stats');
});
    // =============================================
    // 2. TEACHERS MANAGEMENT
    // =============================================
    Route::prefix('admin/teachers')->name('admin.teachers.')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index');
        Route::get('/create', [TeacherController::class, 'create'])->name('create');
        Route::post('/store', [TeacherController::class, 'store'])->name('store');
        Route::get('/{id}', [TeacherController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [TeacherController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TeacherController::class, 'update'])->name('update');
        Route::delete('/{id}', [TeacherController::class, 'destroy'])->name('destroy');
    });

    // =============================================
    // 3. COURSES MANAGEMENT
    // =============================================
    Route::prefix('admin/courses')->name('admin.courses.')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::get('/create', [CourseController::class, 'create'])->name('create');
        Route::post('/store', [CourseController::class, 'store'])->name('store');
        Route::get('/{id}', [CourseController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [CourseController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CourseController::class, 'update'])->name('update');
        Route::delete('/{id}', [CourseController::class, 'destroy'])->name('destroy');
    });

    // =============================================
    // 4. ENROLLMENTS MANAGEMENT
    // =============================================
    Route::prefix('admin/enrollments')->name('admin.enrollments.')->group(function () {
        Route::get('/', [EnrollmentController::class, 'index'])->name('index');
        Route::get('/create', [EnrollmentController::class, 'create'])->name('create');
        Route::post('/store', [EnrollmentController::class, 'store'])->name('store');
        Route::get('/{id}', [EnrollmentController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [EnrollmentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [EnrollmentController::class, 'update'])->name('update');
        Route::delete('/{id}', [EnrollmentController::class, 'destroy'])->name('destroy');
    });

    // =============================================
    // 5. FEE PAYMENTS MANAGEMENT
    // =============================================
  // 5. FEE PAYMENTS MANAGEMENT
// routes/web.php

Route::prefix('admin/fee-payments')->name('admin.fee-payments.')->group(function () {
    Route::get('/', [FeePaymentController::class, 'index'])->name('index');
    Route::get('/create', [FeePaymentController::class, 'create'])->name('create');
    Route::get('/enrollment/{id}', [FeePaymentController::class, 'getEnrollmentDetails'])->name('enrollment.details');
    Route::get('/student/{studentId}/enrollments', [FeePaymentController::class, 'getStudentEnrollments'])->name('student.enrollments');
    Route::get('/student/{studentId}/payments', [FeePaymentController::class, 'getStudentPayments'])->name('student.payments');
    Route::get('/stats', [FeePaymentController::class, 'stats'])->name('stats');
    Route::get('/{id}', [FeePaymentController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [FeePaymentController::class, 'edit'])->name('edit');
    Route::post('/store', [FeePaymentController::class, 'store'])->name('store');
    Route::put('/{id}', [FeePaymentController::class, 'update'])->name('update');
    Route::delete('/{id}', [FeePaymentController::class, 'destroy'])->name('destroy');
});

    // =============================================
    // 6. STUDENT CARDS MANAGEMENT
    // =============================================
   // 6. STUDENT CARDS MANAGEMENT
Route::prefix('admin/student-cards')->name('admin.student-cards.')->group(function () {
    Route::get('/', [StudentCardController::class, 'index'])->name('index');
    Route::get('/create', [StudentCardController::class, 'create'])->name('create');
    Route::post('/store', [StudentCardController::class, 'store'])->name('store');
    Route::get('/{id}', [StudentCardController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [StudentCardController::class, 'edit'])->name('edit');
    Route::put('/{id}', [StudentCardController::class, 'update'])->name('update');
    Route::delete('/{id}', [StudentCardController::class, 'destroy'])->name('destroy');
    // Custom route for issuing multiple cards
    Route::post('/issue', [StudentCardController::class, 'issueCards'])->name('issue');
});

// routes/web.php

// routes/web.php

Route::prefix('admin/certificates')->name('admin.certificates.')->group(function () {
    Route::get('/', [CertificateController::class, 'index'])->name('index');
    Route::get('/create', [CertificateController::class, 'create'])->name('create');
    Route::get('/students', [CertificateController::class, 'getStudents'])->name('students');
    Route::get('/student/{studentId}', [CertificateController::class, 'getStudentData'])->name('student.data');
    Route::get('/stats', [CertificateController::class, 'getStats'])->name('stats');
    
    // Single certificate routes (must be before /{id} to avoid conflicts)
    Route::get('/{id}/preview', [CertificateController::class, 'preview'])->name('preview');
    Route::get('/{id}/print', [CertificateController::class, 'print'])->name('print');
    Route::get('/{id}/edit', [CertificateController::class, 'edit'])->name('edit');
    
    // Main show route
    Route::get('/{id}', [CertificateController::class, 'show'])->name('show');
    
    Route::post('/store', [CertificateController::class, 'store'])->name('store');
    Route::put('/{id}', [CertificateController::class, 'update'])->name('update');
    Route::delete('/{id}', [CertificateController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/verify', [CertificateController::class, 'verify'])->name('verify');
});
// Also keep the main route
Route::get('/admin/certificate', [CertificateController::class, 'index'])->name('admin.certificate');
    // =============================================
    // 8. REPORTS MANAGEMENT
    // =============================================
    Route::prefix('admin/reports')->name('admin.reports.')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('index');
    Route::get('/fee', [ReportController::class, 'feeReport'])->name('fee');
    Route::get('/remaining', [ReportController::class, 'remainingFeeReport'])->name('remaining');
    Route::get('/monthly', [ReportController::class, 'monthlyCollection'])->name('monthly');
    Route::get('/weekly', [ReportController::class, 'weeklyCollection'])->name('weekly');
    Route::get('/daily', [ReportController::class, 'dailyCollection'])->name('daily');
    Route::get('/students', [ReportController::class, 'studentReport'])->name('students');
    Route::get('/certificates', [ReportController::class, 'certificateReport'])->name('certificates');
    Route::get('/{reportType}/data', [ReportController::class, 'getReportData'])->name('data');
    Route::get('/export/{type}', [ReportController::class, 'export'])->name('export');
});


    // =============================================
    // 9. ENQUIRIES MANAGEMENT
    // =============================================
    Route::prefix('admin/enquiries')->name('admin.enquiries.')->group(function () {
        Route::get('/', [EnquiryController::class, 'index'])->name('index');
        Route::get('/create', [EnquiryController::class, 'create'])->name('create');
        Route::post('/store', [EnquiryController::class, 'store'])->name('store');
        Route::get('/{id}', [EnquiryController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [EnquiryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [EnquiryController::class, 'update'])->name('update');
        Route::delete('/{id}', [EnquiryController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/convert', [EnquiryController::class, 'convertToStudent'])->name('convert');
        Route::post('/{id}/status', [EnquiryController::class, 'updateStatus'])->name('status');
    });

    // =============================================
    // 10. WEBSITE CMS & SETTINGS
    // =============================================
    Route::prefix('admin/settings')->name('admin.settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::get('/general', [SettingsController::class, 'general'])->name('general');
        Route::get('/website', [SettingsController::class, 'website'])->name('website');
        Route::get('/academic', [SettingsController::class, 'academic'])->name('academic');
        Route::get('/fees', [SettingsController::class, 'fees'])->name('fees');
        Route::get('/email', [SettingsController::class, 'email'])->name('email');
        Route::get('/backup', [SettingsController::class, 'backup'])->name('backup');
        Route::put('/update', [SettingsController::class, 'update'])->name('update');
        Route::put('/website/update', [SettingsController::class, 'updateWebsite'])->name('website.update');
    });

    // routes/web.php

Route::prefix('admin/talent-test')->name('admin.talent-test.')->group(function () {
    Route::get('/', [TalentTestController::class, 'index'])->name('index');
    
    // API Routes for AJAX
    Route::get('/candidates', [TalentTestController::class, 'getCandidates'])->name('candidates');
    Route::get('/attempts', [TalentTestController::class, 'getAttempts'])->name('attempts');
    Route::get('/stats', [TalentTestController::class, 'getStats'])->name('stats');
    Route::get('/search-candidates', [TalentTestController::class, 'searchCandidates'])->name('search');
    Route::get('/next-roll-number', [TalentTestController::class, 'getNextRollNumber'])->name('next-roll');
    
    // CRUD Operations
    Route::post('/candidate', [TalentTestController::class, 'storeCandidate'])->name('candidate.store');
    Route::post('/attempt', [TalentTestController::class, 'storeAttempt'])->name('attempt.store');
    Route::put('/attempt/{id}/result', [TalentTestController::class, 'updateResult'])->name('attempt.result');
    Route::delete('/candidate/{id}', [TalentTestController::class, 'deleteCandidate'])->name('candidate.delete');
    Route::delete('/attempt/{id}', [TalentTestController::class, 'deleteAttempt'])->name('attempt.delete');
    
    // Force Delete Routes (Permanent Delete)
    Route::delete('/candidate/{id}/force', [TalentTestController::class, 'forceDeleteCandidate'])->name('candidate.force-delete');
    Route::delete('/attempt/{id}/force', [TalentTestController::class, 'forceDeleteAttempt'])->name('attempt.force-delete');
    
    // Reset Route
    Route::post('/reset', [TalentTestController::class, 'resetRollNumbers'])->name('reset');
});

});

// Fallback route for any undefined routes
Route::fallback(function () {
    return redirect()->route('login');
});