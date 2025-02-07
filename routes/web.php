<?php
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;  
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\RegistrationController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::get('/greeting', function () {
    return 'Hello World';
}); 

Route::get('/user/{id}', function (string $id) {
    return 'User '.$id;
});
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);// ใช้งานได้เฉพาะผู้ที่ล็อกอิน

Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');

Route::resource('customers', CustomerController::class);
Route::resource('rooms', RoomController::class);
Route::resource('bookings', BookingController::class);
Route::resource('roomtypes', RoomTypeController::class);

Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

Route::get('/room-types', [RoomTypeController::class, 'index'])->name('room-types.index');
Route::get('/room-types/{roomType}', [RoomTypeController::class, 'show'])->name('room-types.show');

Route::prefix('reg')->name('reg.')->group(function () {
    Route::get('/', [RegistrationController::class, 'index'])->name('index');
    Route::get('/create', [RegistrationController::class, 'create'])->name('create');
    Route::post('/', [RegistrationController::class, 'store'])->name('store');
    Route::get('/{registration}/edit', [RegistrationController::class, 'edit'])->name('edit');
    Route::put('/{registration}', [RegistrationController::class, 'update'])->name('update');
    Route::delete('/{registration}', [RegistrationController::class, 'destroy'])->name('destroy');
    Route::get('/stats', [RegistrationController::class, 'stats'])->name('stats');
});

Route::resource('products', ProductController::class);

require __DIR__.'/auth.php';
