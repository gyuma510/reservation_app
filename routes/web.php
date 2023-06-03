<?php

use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\FrameController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\Auth\ResetPasswordController;
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

// Auth関係
Auth::routes(['register' => false]);
// パスワードリセット
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('auth.passwords.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
// メールアドレス変更
Route::post('/password/email', [ResetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 宿泊予約関係
Route::prefix('reservations')->name('reservations.')->controller(ResrevationController::class)->group(function () {
    Route::get('top', [ReservationController::class, 'top'])->name('top');
    Route::get('access', [ReservationController::class, 'access'])->name('access');
    Route::get('room', [ReservationController::class, 'room'])->name('room');
    Route::get('', [ReservationController::class, 'index'])->name('index');
    Route::get('{id}', [ReservationController::class, 'show'])->name('show');
    Route::get('create/{plan_id}/{frame_id}', [ReservationController::class, 'create'])->name('create');
    Route::post('confirm', [ReservationController::class, 'confirm'])->name('confirm');
    Route::post('store', [ReservationController::class, 'store'])->name('store');
    Route::get('complete', function () {
        return view('complete');
    })->name('complete');
});

// 空室カレンダー
Route::get('availability/calendar/{id}', [AvailabilityController::class, 'calendar'])->name('availability.calendar');
Route::get('/availability/calendar-data', [AvailabilityController::class, 'calendarData'])->name('availability.calendar-data');

// お問合せ関係
Route::get('admin/contacts', [ContactController::class, 'index'])->name('admin.contacts.index');
Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
Route::post('/contacts/store', [ContactController::class, 'store'])->name('contacts.store');
Route::get('admin/contacts/{id}', [ContactController::class, 'show'])->name('admin.contacts.show');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    // 管理者ログイン後
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // お問い合わせステータス
    Route::match(['post', 'delete'], 'contacts/{contact}/status', [StatusController::class, 'update'])->name('contacts.status');

    // 予約枠関係
    Route::get('frames', [FrameController::class, 'index'])->name('frames.index');
    Route::get('frames/create', [FrameController::class, 'create'])->name('frames.create');
    Route::post('frames/store', [FrameController::class, 'store'])->name('frames.store');
    Route::get('frames/edit/{id}', [FrameController::class, 'edit'])->name('frames.edit');
    Route::put('frames/update/{id}', [FrameController::class, 'update'])->name('frames.update');
    Route::delete('frames/destroy/{id}', [FrameController::class, 'destroy'])->name('frames.destroy');

    // 一括登録関係
    Route::get('frames/create-bulk', [FrameController::class, 'createBulk'])->name('frames.createBulk');
    Route::post('frames/store-bulk', [FrameController::class, 'storeBulk'])->name('frames.storeBulk');

    // 宿泊プラン関係
    Route::get('plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::post('plans/store', [PlanController::class, 'store'])->name('plans.store');
    Route::get('plans/{id}', [PlanController::class, 'show'])->name('plans.show');
    Route::get('plans/edit/{id}', [PlanController::class, 'edit'])->name('plans.edit');
    Route::put('plans/update/{id}', [PlanController::class, 'update'])->name('plans.update');
    Route::delete('plans/destroy/{id}', [PlanController::class, 'destroy'])->name('plans.destroy');
});
