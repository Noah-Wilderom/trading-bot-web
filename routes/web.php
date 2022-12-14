<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BotLogsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\BotSessionController;
use Spatie\Health\Http\Controllers\HealthCheckResultsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/settings', [SettingsController::class, 'index'])->middleware(['auth'])->name('user.settings');
Route::get('/bot/{uuid}', [BotLogsController::class, 'index'])->middleware(['auth'])->name('bot.logs');

Route::get('health', HealthCheckResultsController::class);

// Route::resource('bot', BotSessionController::class);

require __DIR__.'/auth.php';
