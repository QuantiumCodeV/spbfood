<?php

use App\Http\Controllers\SiteController;
use App\Http\Controllers\AmoController;
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
    return view('index');
});
Route::get('/site/order', function () {
    return view('order');
});

// Маршруты для заказа
Route::post('/site/order', [SiteController::class, 'addToOrder']);
Route::get('/site/order', [SiteController::class, 'order']);
Route::post('/amo/check_promocode', [SiteController::class, 'checkPromocode']);

// Маршруты для отправки в Telegram
Route::middleware(['throttle:5,1'])->group(function () {
    Route::post('/amo/call', [AmoController::class, 'call']);
    Route::post('/amo/order2', [AmoController::class, 'order2']);
    Route::post('/amo/order3', [AmoController::class, 'order3']);
});

// Маршрут для оформления заказа через сайт
Route::post('/site/submit-order', [SiteController::class, 'submitOrder'])->name('order.submit');
Route::get('/site/order-success/{order_id}', [SiteController::class, 'orderSuccess'])->name('order.success');

Route::get('/site/success', function () {
    return view('success');
})->name('order.success');

// Добавьте этот маршрут для обработки отправки формы заказа
Route::post('/site/submit-order', [App\Http\Controllers\AmoController::class, 'submitOrder']);

// Отладочный маршрут - только для разработки, удалить в продакшене
Route::get('/debug/session', function () {
    if (config('app.debug')) {
        return response()->json([
            'order_data' => session('order_data'),
            'promocode' => session('promocode')
        ]);
    }

    return redirect('/');
});
