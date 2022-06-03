<?php

namespace App\Algorithms;

use App\Models\Warehouse;
use App\Models\Warehouse_good;
use App\Models\WarehouseTradeGoodsSuggestion;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class WarehouseWarehouseDistribution
{
    public static function distribute()
    {
        $month = Carbon::now()->addMonth()->format('m');
        $start = Carbon::now()->subDays(now()->day);
        $end = Carbon::createFromDate(null, $month)->subDay();
        $remain1 = now()->diff($end)->days;
        $remain2 = $end->diff($start)->days;
        $scale = $remain1 / $remain2;

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
                WarehouseTradeGoodsSuggestion::query()
                    ->create([
                        'warehouse_id' => $warehouseId,
                        'good_id' => $good->id,
                        'warehouses' => json_encode($warehouses)
                    ]);
            }
        }
    }
}
