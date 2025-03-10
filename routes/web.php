<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ConnectionsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PostController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/{user}', [ProfileController::class, 'view'])->name('profile.view');
    Route::get('/my-profile', [ProfileController::class, 'index'])->name('profile.index');
    
    // Skills routes
    Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
    Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');
    
    // Connection routes
    Route::get('/connections', [ConnectionsController::class, 'index'])->name('connections.index');
    Route::post('/connections/request/{user}', [ConnectionsController::class, 'request'])->name('connections.request');
    Route::post('/connections/accept/{connection}', [ConnectionsController::class, 'accept'])->name('connections.accept');
    Route::post('/connections/reject/{connection}', [ConnectionsController::class, 'reject'])->name('connections.reject');
    Route::delete('/connections/remove/{connection}', [ConnectionsController::class, 'remove'])->name('connections.remove');
    
    // Posts routes
    Route::resource('posts', PostController::class);
});

require __DIR__.'/auth.php';
