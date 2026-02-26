<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $latestPets = \App\Models\Pet::with('user')
        ->where('status', 'active')
        ->latest()
        ->take(6)
        ->get();

    $featuredBusinesses = \App\Models\Business::with('plan')
        ->where('status', 'active')
        ->has('plan') // Negocios con plan activo (Premium/Elite)
        ->inRandomOrder()
        ->take(3)
        ->get();

    return Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'latestPets' => $latestPets,
    'featuredBusinesses' => $featuredBusinesses,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');

    Route::get('/pets/create', [\App\Http\Controllers\PetController::class , 'create'])->name('pets.create');
    Route::post('/pets', [\App\Http\Controllers\PetController::class , 'store'])->name('pets.store');

    Route::get('/businesses/create', [\App\Http\Controllers\BusinessController::class , 'create'])->name('businesses.create');
    Route::post('/businesses', [\App\Http\Controllers\BusinessController::class , 'store'])->name('businesses.store');

    Route::get('/plans', [\App\Http\Controllers\PlanController::class , 'index'])->name('plans.index');
    Route::get('/subscriptions/create', [\App\Http\Controllers\SubscriptionController::class , 'create'])->name('subscriptions.create');
    Route::post('/subscriptions', [\App\Http\Controllers\SubscriptionController::class , 'store'])->name('subscriptions.store');

    // Mis Publicaciones
    Route::get('/mis-mascotas', [\App\Http\Controllers\MyPetController::class , 'index'])->name('my-pets.index');
    Route::post('/pets/{pet}/close', [\App\Http\Controllers\MyPetController::class , 'close'])->name('my-pets.close');
    Route::post('/pets/{pet}/reopen', [\App\Http\Controllers\MyPetController::class , 'reopen'])->name('my-pets.reopen');

    // Reportar publicación
    Route::post('/pets/{pet}/report', [\App\Http\Controllers\ReportController::class , 'store'])->name('pets.report');

    // Editar negocio
    Route::get('/businesses/{business}/edit', [\App\Http\Controllers\BusinessController::class , 'edit'])->name('businesses.edit');
    Route::patch('/businesses/{business}', [\App\Http\Controllers\BusinessController::class , 'update'])->name('businesses.update');

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
            Route::get('/', function () {
                    return redirect()->route('admin.dashboard');
                }
                );
                Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class , 'index'])->name('dashboard');

                // Moderation
                Route::get('/pets', [\App\Http\Controllers\Admin\PetModerationController::class , 'index'])->name('pets.index');
                Route::post('/pets/{pet}/approve', [\App\Http\Controllers\Admin\PetModerationController::class , 'approve'])->name('pets.approve');
                Route::post('/pets/{pet}/reject', [\App\Http\Controllers\Admin\PetModerationController::class , 'reject'])->name('pets.reject');

                Route::get('/businesses', [\App\Http\Controllers\Admin\BusinessModerationController::class , 'index'])->name('businesses.index');
                Route::post('/businesses/{business}/approve', [\App\Http\Controllers\Admin\BusinessModerationController::class , 'approve'])->name('businesses.approve');
                Route::post('/businesses/{business}/reject', [\App\Http\Controllers\Admin\BusinessModerationController::class , 'reject'])->name('businesses.reject');

                // User Management
                Route::get('/users', [\App\Http\Controllers\Admin\UserController::class , 'index'])->name('users.index');
                Route::post('/users/{user}/block', [\App\Http\Controllers\Admin\UserController::class , 'block'])->name('users.block');
                Route::post('/users/{user}/unblock', [\App\Http\Controllers\Admin\UserController::class , 'unblock'])->name('users.unblock');

                // Reports
                Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class , 'index'])->name('reports.index');
                Route::post('/reports/{report}/resolve', [\App\Http\Controllers\Admin\ReportController::class , 'resolve'])->name('reports.resolve');
                Route::delete('/reports/{report}', [\App\Http\Controllers\Admin\ReportController::class , 'destroy'])->name('reports.destroy');

                // Audits
                Route::get('/audits', [\App\Http\Controllers\Admin\AuditController::class , 'index'])->name('audits.index');

                // Subscriptions
                Route::get('/subscriptions', [\App\Http\Controllers\Admin\SubscriptionController::class , 'index'])->name('subscriptions.index');
            }
            );
        });

Route::get('/pets', [\App\Http\Controllers\PetController::class , 'index'])->name('pets.index');
Route::get('/pets/{pet}', [\App\Http\Controllers\PetController::class , 'show'])->name('pets.show');

Route::get('/businesses', [\App\Http\Controllers\BusinessController::class , 'index'])->name('businesses.index');
Route::get('/businesses/{business}', [\App\Http\Controllers\BusinessController::class , 'show'])->name('businesses.show');

require __DIR__ . '/auth.php';
