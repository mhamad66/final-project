<?php

use App\Models\Warehouse;
use App\Models\Warehouse_good;
use App\Models\WarehouseTradeGoodsSuggestion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/test', function () {
    \App\Algorithms\ImportDistribution::distribute([
        1 => 280,
        2 => 90,
        3 => 70,
    ]);
});
