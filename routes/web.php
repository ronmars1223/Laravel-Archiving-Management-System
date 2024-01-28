<?php

use App\Livewire\Admin\Document as AdminDocument;
use App\Livewire\Admin\Recyclebin;
use App\Livewire\Admin\Settings;
use App\Livewire\User\Document as UserDocument;
use App\Livewire\Admin\ApproveUser;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Login as AdminLogin;
use App\Livewire\User\Dashboard;
use App\Livewire\User\Login;
use App\Livewire\User\Register;
use App\Models\Admin;
use Illuminate\Support\Facades\Route;

// Admin login route as default for root URL
Route::get('/', AdminLogin::class)->name('admin.login');

# User Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/user/register', Register::class)->name('user.register');
    Route::get('/user/login', Login::class)->name('user.login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', Dashboard::class)->name('user.dashboard');
    Route::get('/user/document', UserDocument::class)->name('user.document');
});

// Admin
Route::middleware(['guest:admin'])->group(function () {
    Route::get('/admin/login', AdminLogin::class)->name('admin.login');
});

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/admin/users', ApproveUser::class)->name('admin.users');
    Route::get('/admin/document', AdminDocument::class)->name('admin.document');
    Route::get('/admin/recyclebin', Recyclebin::class)->name('admin.recyclebin');
    Route::get('/admin/settings', Settings::class)->name('admin.settings');
    Route::get('/documents/view/{id}', AdminDocument::class)->name('documents.view');
});
Route::get('/get-document-content/{documentId}', [AdminDocument::class, 'getDocumentContent'])
        ->name('get.document.content');
        Route::get('/get-document-content/{documentId}', [UserDocument::class, 'getDocumentContent'])
        ->name('get.document.content');

