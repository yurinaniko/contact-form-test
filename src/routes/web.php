<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect('/contact');
});

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:6,1');

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:6,1');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/contact', [FormController::class, 'index'])->name('contact.index');
Route::post('/contact/confirm', [FormController::class, 'confirm'])->name('contact.confirm');
Route::post('/contact/thanks', [FormController::class, 'thanks'])->name('contact.thanks');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');
    Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    // export は auth グループの外に置くとコントローラ側の auth 依存だけになり脆いため、グループ内へ移設（多層防御）
    Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');
});