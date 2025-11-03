<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CategoryController;

// Route pour la page d'accueil
Route::get('/', [PageController::class, 'welcome'])->name('welcome');

// Routes pour le formulaire de contact
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Affiche le formulaire d'inscription
Route::get('/inscription', [AuthController::class, 'showRegisterForm'])->name('register');
// Traite les données du formulaire
Route::post('/inscription', [AuthController::class, 'register']);

// Connexion
Route::get('/connexion', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/connexion', [AuthController::class, 'login']);

// Déconnexion
Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout');

// Gestion des projets (protégé)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ProjectController::class, 'index'])->name('dashboard');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    // Soft delete
    Route::get('/projects/trash', [ProjectController::class, 'trash'])->name('projects.trash');
    Route::patch('/projects/{project}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
    // Routes pour les projets
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::patch('/projects/{project}/archive', [ProjectController::class, 'archive'])->name('projects.archive');


    // Gestion des tâches
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Routes pour le profil utilisateur
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    // Routes pour les clients
    Route::resource('clients', ClientController::class);

    // Categories
    Route::resource('categories', CategoryController::class);
});

Route::middleware(['auth', 'can:view-admin-panel'])->group(function () {
    Route::get('/admin/messages', [MessageController::class, 'index'])->name('admin.messages.index');
});
