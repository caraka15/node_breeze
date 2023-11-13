<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ChaindController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminChaindController;

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

// Route::get('/', function () {
//     return view('home');
// });

Route::get('/', [ChaindController::class, 'index'])->name('home');

Route::get('/posts', function () {
    return view('posts');
})->name('posts');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard/user', function () {
        return view('user');
    })->name('user');
    Route::get('/dashboard/chainds/checkSlug', [AdminChaindController::class, 'checkSlug']);
    Route::resource('/dashboard/chainds', AdminChaindController::class)->names([
        'index' => 'chainds.index',
        'create' => 'chainds.create',
        'store' => 'chainds.store',
        'show' => 'chainds.show',
        'edit' => 'chainds.edit',
        'update' => 'chainds.update',
        'destroy' => 'chainds.destroy',
    ]);
    Route::resource('/dashboard/posts', PostController::class)->names([
        'index' => 'posts.index',
        'create' => 'posts.create',
        'store' => 'posts.store',
        'show' => 'posts.show',
        'edit' => 'posts.edit',
        'update' => 'posts.update',
        'destroy' => 'posts.destroy',
    ]);
});

require __DIR__.'/auth.php';

Route::get('/{chaind:slug}', [ChaindController::class, 'show']);