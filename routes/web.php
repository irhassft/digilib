<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController; // <--- Import Controller
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    $documents = \App\Models\Document::with(['category', 'uploader'])->latest()->take(6)->get();
    return view('welcome', compact('documents'));
});

// Grup Route untuk User yang sudah Login
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard (Semua role bisa akses)
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::get('/documents/{document}/view', [DocumentController::class, 'view'])->name('documents.view');
    
    Route::get('/dashboard', [DocumentController::class, 'index'])->name('dashboard');

    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])
    ->name('documents.download');

    // ====================================================
    // 1. GROUP KHUSUS SUPER ADMIN (Hanya Level Tertinggi)
    // ====================================================
    Route::group(['middleware' => ['role:super-admin']], function () {
        // Pindahkan route users ke SINI
        Route::resource('users', App\Http\Controllers\UserController::class);

        // MANAJEMEN USER (Hanya Super Admin)
        Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'destroy']);
    });

    // --- AREA KHUSUS ADMIN & SUPER ADMIN ---
    // Menggunakan middleware 'role' dari Spatie
    Route::group(['middleware' => ['role:admin|super-admin']], function () {
        
        // Upload
        Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
        Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
        
        // Edit
        Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
        Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
        
        // Delete
        Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
        
        // Di dalam group middleware admin/super-admin
        Route::delete('/categories/{category}/ajax', [CategoryController::class, 'destroy'])->name('categories.ajax.destroy');
        
        Route::post('/categories/ajax', [CategoryController::class, 'store'])->name('categories.ajax.store');
    });
    // ---------------------------------------

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});



require __DIR__.'/auth.php';