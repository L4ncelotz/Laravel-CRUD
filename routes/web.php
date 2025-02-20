<?php
use App\Http\Controllers\ChirpController;
use Illuminate\Foundation\Application;  
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/user/{id}', function (string $id) {
    return 'User '.$id;
});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);// ใช้งานได้เฉพาะผู้ที่ล็อกอิน


require __DIR__.'/auth.php';
