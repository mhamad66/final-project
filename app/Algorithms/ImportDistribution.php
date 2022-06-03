<?php

namespace App\Algorithms;

use App\Models\Warehouse;
use App\Models\Warehouse_good;
use Illuminate\Support\Facades\DB;

class ImportDistribution
{
    /**
     * @param $goods array of goods' ids with amount for each one ex: [1 => 10, ...]
     */
    public static function distribute($goods)
    {
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
            $rate = ($warehouseGood->avg_amount / $count[$warehouseGood->good_id]) * $goods[$warehouseGood->good_id];
            $distributed[] = [
                'warehouse_good_id' => $warehouseGood->id,
                'amount' => $rate
            ];
        }

        return $distributed;
    }

    public static function getOrder()
    {
        $importGoods = Warehouse_good::query()
            ->select('good_id', DB::raw('SUM(avg_amount) as sum'))
            ->groupBy('good_id')
            ->get();

        $order = [];

        foreach ($importGoods as $good) {
            $order[] = [
                'good_id' => $good->good_id,
                'amount' => (int)($good->sum * 1.1), // todo : make it dynamic
            ];
        }

        return $order;
    }
}
