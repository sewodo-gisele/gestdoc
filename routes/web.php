<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Users\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/apropos', [PagesController::class, 'apropos'])->name('pages.Apropos');
Route::get('/fonctionnalite', [PagesController::class, 'fonctionnalite'])->name('pages.fonctionnalite');
Route::get('/contact', [PagesController::class, 'contact'])->name('pages.contact');
Route::get('/login', [PagesController::class, 'login'])->name('auth.login');

Route::get('/register', [PagesController::class, 'register'])->name('auth.register');
Route::post('/register', [App\Http\Controllers\Auth\register::class, 'register'])->name('auth.register.submit');
Route::post('/login', [App\Http\Controllers\Auth\login::class, 'login'])->name('auth.login.submit');
Route::post('/logout', [App\Http\Controllers\Auth\login::class, 'logout'])->name('auth.logout');


// Dashboards selon le rôle
Route::get('/admin/dashboard', [Dashboard::class, 'index'])->name('admin.dashboard');
// Route::get('/admin/dashboard', function () {
//     return view('Admin.Dashboard');
// })->name('admin.dashboard');

Route::get('/user/dashboard', [DocumentController::class, 'index'])->name('user.dashboard');
Route::get('/user/documents', [DocumentController::class, 'documentList'])->name('user.documents');
// Route::get('/user/dashboard', function () {
//     return view('Users.Dashboard');
// })->name('user.dashboard');

// Route vers la liste des documents pour l'admin
Route::get('/admin/listedocument', [Dashboard::class, 'listedocument'])->name('admin.listedocument');
// Route::get('/admin/utilisateur', [Dashboard::class, 'listedocument'])->name('admin.listedocument');
// Route vers la gestion des utilisateurs pour l'admin
Route::get('/admin/utilisateurs', [UserController::class, 'utilisateur'])->name('admin.utilisateurs');
Route::get('/admin/utilisateurs', [Dashboard::class, 'utilisateur'])->name('admin.utilisateurs');
// Route vers la liste des utilisateurs pour l'admin


// Route pour afficher le dashboard
Route::get('/dashboard', [DocumentController::class, 'index'])->name('dashboard');

// Route pour traiter le formulaire de téléversement
Route::post('/documents/upload', [DocumentController::class, 'store'])->name('documents.store');
Route::get('/documents/download/{id}', [DocumentController::class, 'download'])->name('documents.download');
Route::get('/documents/show/{id}', [DocumentController::class, 'show'])->name('document.show');
Route::put('/documents/approuved/{id}', [DocumentController::class, 'approuved'])->name('documents.approuved');
Route::delete('/documents/rejected/{id}', [DocumentController::class, 'rejected'])->name('documents.rejected');

// Route::resource('users', UserController::class);
Route::get('/users', [App\Http\Controllers\Users\UserController::class, 'index'])->name('users.index');
Route::get('/users/{id}', [App\Http\Controllers\Users\UserController::class, 'show'])->name('users.show');
Route::get('/users/{id}/edit', [App\Http\Controllers\Users\UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [App\Http\Controllers\Users\UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [App\Http\Controllers\Users\UserController::class, 'destroy'])->name('users.destroy');

Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');