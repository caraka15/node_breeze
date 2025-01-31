<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ChaindController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExordeController;
use App\Http\Controllers\ExordeApiController;
use App\Http\Controllers\AirdropController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\guestPostController;
use App\Http\Controllers\AdminChaindController;
use App\Http\Controllers\TelegramController;

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

Route::get('/blogs', [guestPostController::class, 'index'])->name('posts');

Route::get('/config', [ConfigController::class, 'config'])->name('config');

Route::get('/generate-sitemap', [SitemapController::class, 'generate']);


Route::get('/exorde-stats', [ExordeController::class, 'index']);

Route::get('/exorde-api', [ExordeApiController::class, 'getStats']);

Route::get('/airdrop/export-to-excel', [AirdropController::class, 'exportToExcel'])->name('airdrops.export.to.excel');
Route::get('/airdrop/selesai-filter', [AirdropController::class, 'selesaiFilter'])->name('airdrops.selesai.filter');


Route::resource('/airdrop', AirdropController::class)->names([
    'airdrop.index' => 'airdrop.index',
    'airdrop.create' => 'airdrop.create',
    'airdrop.store' => 'airdrop.store',
    'airdrop.show' => 'airdrop.show',
    'airdrop.edit' => 'airdrop.edit',
    'airdrop.update' => 'airdrop.update',
    'airdrop.destroy' => 'airdrop.destroy',
]);;


Route::get('/dashboard', function () {
    return view('dashboard', [
        'title' => "Dashboard"
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard/posts/checkSlug', [PostController::class, 'checkSlug']);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/dashboard/users', UserController::class)->names([
        'users.index' => 'users.index',
        'users.create' => 'users.create',
        'users.store' => 'users.store',
        'users.show' => 'users.show',
        'users.edit' => 'users.edit',
        'users.update' => 'users.update',
        'users.destroy' => 'users.destroy',
    ]);
    Route::resource('/dashboard/posts', PostController::class)->names([
        'posts.index' => 'posts.index',
        'posts.create' => 'posts.create',
        'posts.store' => 'posts.store',
        'posts.show' => 'posts.show',
        'posts.edit' => 'posts.edit',
        'posts.update' => 'posts.update',
        'posts.destroy' => 'posts.destroy',
    ]);

    Route::put('/airdrop/status/{id}', [AirdropController::class, 'checkedUpdate'])->name('airdrop-checked');

    Route::put('/airdrop/selesai/{id}', [AirdropController::class, 'checkedSelesai'])->name('airdrop-selesai');

    Route::put('/airdrop/salary/{id}', [AirdropController::class, 'EditSalary'])->name('airdrop-salary');
});
Route::middleware(['auth', 'isAdmin'])->group(function () {
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
    Route::resource('/dashboard/config', ConfigController::class)->names([
        'config.index' => 'config.index',
        'config.create' => 'config.create',
        'config.store' => 'config.store',
        'config.show' => 'config.show',
        'config.edit' => 'config.edit',
        'config.update' => 'config.update',
        'config.destroy' => 'config.destroy',
    ]);
});

Route::get('/send-telegram-notification', [TelegramController::class, 'sendNotification']);

require __DIR__ . '/auth.php';

Route::get('/{chaind:slug}', [ChaindController::class, 'show']);


Route::get('/blogs/{post:slug}', [guestPostController::class, 'show'])->name('blogs.show');

Route::post("/connect-metamask", function () {
    $requestData = json_decode(request()->getContent(), true);
    $connectedAddress = $requestData["connectedAddress"];

    // Simpan alamat yang terhubung ke dalam sesi
    Session::put("connectedAddress", $connectedAddress);

    return response()->json(["message" => "Connected address saved successfully"]);
});
