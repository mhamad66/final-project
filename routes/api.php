<?php

use App\Algorithms\WarehouseWarehouseDistribution;
use App\Http\Controllers\AuthController;
use App\Models\Warehouse;
use App\Models\Warehouse_good;
use App\Models\WarehouseTradeGoodsSuggestion;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShowroomController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\warehouseGoodsController;
use App\Http\Controllers\SampleController;

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

//public Route
Route::post('/register', [AuthController::class, 'Register']);
Route::post('/login', [AuthController::class, 'Login']);
Route::get('/logout', [AuthController::class, 'Logout'])->middleware('auth:sanctum');


// protected Route
Route::group(['middleware' => 'auth:sanctum'], function () {

});
//----------------warehouses---------------------------
Route::get('/warehouses/index', [WarehouseController::class, 'index']);
Route::get('/warehouses/view/{id}', [WarehouseController::class, 'show']);
Route::get('/warehouses/delete/{id}', [WarehouseController::class, 'destroy']);
Route::post('/warehouses', [WarehouseController::class, 'store']);
Route::post('/warehouses/{id}', [WarehouseController::class, 'update']);
//----------------warehouse Goods---------------------------
Route::get('/warehouseGoods/index', [warehouseGoodsController::class, 'index']);
Route::get('/warehouseGoods/view/{id}', [warehouseGoodsController::class, 'show']);
Route::get('/warehouseGoods/delete/{id}', [warehouseGoodsController::class, 'destroy']);
Route::post('/warehouseGoods', [warehouseGoodsController::class, 'store']);
Route::post('/warehouseGoods/{id}', [warehouseGoodsController::class, 'update']);
//---------------showrooms----------------------------
Route::get('/showrooms/index', [ShowroomController::class, 'index']);
Route::get('/showrooms/view/{id}', [ShowroomController::class, 'show']);
Route::get('/showrooms/delete/{id}', [ShowroomController::class, 'destroy']);
Route::post('/showrooms', [ShowroomController::class, 'store']);
Route::post('/showrooms/{id}', [ShowroomController::class, 'update']);
//----------------samples------------------------------
Route::get('/Goods/index', [\App\Http\Controllers\GoodController::class, 'index']);
Route::get('/samples/view/{id}', [SampleController::class, 'show']);
Route::get('/samples/delete/{id}', [SampleController::class, 'destroy']);
Route::post('/samples', [SampleController::class, 'store']);
Route::post('/samples/{id}', [SampleController::class, 'update']);
//----------------Users----------------------------------------
Route::get('/users/index', [\App\Http\Controllers\UserController::class, 'index']);
Route::get('/users/view/{id}', [\App\Http\Controllers\UserController::class, 'show']);
Route::get('/users/delete/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);
Route::post('/users', [\App\Http\Controllers\UserController::class, 'store']);
Route::post('/users/{id}', [\App\Http\Controllers\UserController::class, 'update']);

//----------------GoodTypes----------------------------------------
Route::get('/goodTypes/index', [\App\Http\Controllers\GoodTypesController::class, 'index']);
Route::get('/goodTypes/delete/{id}', [\App\Http\Controllers\GoodTypesController::class, 'destroy']);
Route::post('/goodTypes', [\App\Http\Controllers\GoodTypesController::class, 'store']);
//----------------TEST1----------------------------------------

Route::get('/testWarehouseWarehouseDistribution', function () {

    $month = Carbon::now()->addMonth()->format('m');
    $start = Carbon::now()->subDays(now()->day);

    $end = Carbon::createFromDate(null, $month)->subDay();

    $remain1 = now()->diff($end)->days;
    $remain2 = $end->diff($start)->days;
    $scale = $remain1 / $remain2;
    dd($scale);

    $warehouseGoods = Warehouse_good::query()
        ->where('current_amount', '<', DB::raw('avg_amount * ' . $scale))
        ->get('*')
        ->groupBy('warehouse_id');
    foreach ($warehouseGoods as $warehouseId => $goods) {
        $warehouse = Warehouse::find($warehouseId);

        foreach ($goods as $good) {
            $warehouses = Warehouse::query()
                ->whereHas('goods', function (Builder $q) use ($good) {
                    $q->where('avg_amount', '<', DB::raw('current_amount'))
                        ->where('good_id', $good->id);
                })
                ->get();

            $warehouses->each(function ($other) use ($warehouse) {
                $longDif = ($other->longitude - $warehouse->longitude);
                $latDif = ($other->latitude - $warehouse->latitude);
                $other->distance = sqrt($longDif * $longDif + $latDif * $latDif);
            });

            $warehouses = $warehouses->sortBy('distance')->pluck('id');

            var_dump(' $warehouseId ==>' . $warehouseId . '   good_id ==> ' . $good->id . '  warehouses ' . json_encode($warehouses));
//            WarehouseTradeGoodsSuggestion::query()
//                ->create([
//                    'warehouse_id' => $warehouseId,
//                    'good_id' => $good->id,
//                    'warehouses' => json_encode($warehouses)
//                ]);
        }
    }
});
//----------------Test2----------------------------------------
Route::get('/ImportDistribution', function () {
    $goods = [1 => 150];
//    pass array [good_id => amount]

    $importGoods = Warehouse_good::query()
        ->select('good_id', DB::raw('SUM(avg_amount) as sum'))
        ->groupBy('good_id')
        ->get();
    $count = [];
    foreach ($importGoods as $good) {
        $count[$good->good_id] = $good->sum;
    }

    $warehouseGoods = Warehouse_good::all();
    $distributed = [];
    foreach ($warehouseGoods as $warehouseGood) {
        if(!empty($goods[$warehouseGood->good_id])){
            $rate = ($warehouseGood->avg_amount / $count[$warehouseGood->good_id]) * $goods[$warehouseGood->good_id];
        }else{
            $rate = ($warehouseGood->avg_amount / $count[$warehouseGood->good_id]) *1;

        }
        $rate = floor($rate);

        $warhouseId = Warehouse::find($warehouseGood->warehouse_id);
        $good = \App\Models\Good::find($warehouseGood->good_id);

        $distributed[] = [
            'district' =>$warhouseId->district,
            'address'=>$warhouseId->address,
            'good_name'=>$good->good_name,
            'company'=>$good->company,
             'warehouse_good_id' => $warehouseGood->id,
            'amount' => $rate
        ];
    }
//    dd($distributed);
//$distributed.foreach (res)

    return $distributed;
});
//--------------Test3--------------------------------------
Route::get('/getOrder', function () {
    $importGoods = Warehouse_good::query()
        ->select('good_id', DB::raw('SUM(avg_amount) as sum'))
        ->groupBy('good_id')
        ->get();
    $order = [];

    foreach ($importGoods as $good) {
        $goodWithAllData=        \App\Models\Good::find($good->good_id);
        $order[] = [
            'name'=>$goodWithAllData->good_name,
            'company'=>$goodWithAllData->company,
            'good_id' => $good->good_id,
            'amount' => (int)($good->sum * 1.1),
        ];
    }
    return $order;
})->name('getOrder');

//notification

Route::get('/notification',[\App\Http\Controllers\NotificationController::class,'getNotification']);
//Route::post('/notificationReadied/{id}',[\App\Http\Controllers\NotificationController::class,'readed']);

