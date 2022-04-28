<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExchangeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('get-values', [ExchangeController::class, 'getValues']);
Route::post('make-exchange-order', [ExchangeController::class, 'makeExchangeOrder']);
Route::post('calculate', [ExchangeController::class, 'getCalculate']);
Route::post('calculate-with-surcharge', [ExchangeController::class, 'getCalculateWithSurcharge']);
//Route::post('action', [ExchangeController::class, 'action']);
