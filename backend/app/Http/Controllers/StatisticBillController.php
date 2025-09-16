<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\Bill;
use Carbon\Carbon;

use Illuminate\Support\Facades\Cache;

class StatisticBillController extends Controller
{
    public function countAllBill(int $range = 30, ?string $status = null): JsonResponse
    {
        $now = Carbon::now();
        $fromDate = $now->copy()->subDays($range);

        $cacheKey = "bills_count:{$range}:" . ($status ?? 'all');

        $count = Cache::remember($cacheKey, 60, function () use ($fromDate, $now, $status) {
            $query = Bill::whereBetween('created_at', [$fromDate, $now]);

            if ($status !== null) {
                $query->where('status', $status);
            }

            return $query->count();
        });

        return response()->json([
            'count' => $count,
            'from' => $fromDate->toISOString(),
            'to'   => $now->toISOString(),
            'status' => $status ?? 'all',
        ]);
    }


    public function sumBills(int $range = 30, ?string $status = null): JsonResponse
    {
        $now = Carbon::now();
        $fromDate = $now->copy()->subDays($range);
        $cacheKey = "bills_count:{$range}:" . ($status ?? 'all');

        $sum = Cache::remember($cacheKey, 60, function () use ($fromDate, $now, $status) {
            $query = Bill::whereBetween('created_at', [$fromDate, $now]);

            if ($status !== null) {
                $query->where('status', $status);
            }

            return $query->sum('total_sum');
        });

        return response()->json([
            'sum' => $sum,
            'from' => $fromDate->toISOString(),
            'to' => $now->toISOString(),
            'status' => $status ?? 'all',
        ]);
    }

    public function averageBill(int $range = 30, ?string $status = null): JsonResponse
    {
        $now = Carbon::now();
        $fromDate = $now->copy()->subDays($range);

        $cacheKey = "bills_count:{$range}:" . ($status ?? 'all');

        $average =  Cache::remember($cacheKey, 60, function () use ($fromDate, $now, $status) {
            $query = Bill::whereBetween('created_at', [$fromDate, $now]);

            if ($status !== null) {
                $query->where('status', $status);
            }

            return $query->sum('total_sum');
        });

        return response()->json([
            'average' => round($average, 2),
            'from' => $fromDate->toISOString(),
            'to' => $now->toISOString(),
            'status' => $status ?? 'all',
        ]);
    }

    public function countByStatus(int $range = 30): JsonResponse
    {
        $now = Carbon::now();
        $fromDate = $now->copy()->subDays($range);

        $counts = Bill::whereBetween('created_at', [$fromDate, $now])
            ->select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return response()->json([
            'counts' => $counts,
            'from' => $fromDate->toISOString(),
            'to' => $now->toISOString(),
        ]);
    }


    public function dailyCount(int $range = 30, ?string $status = null): JsonResponse
    {
        $now = Carbon::now();
        $fromDate = $now->copy()->subDays($range);

        $query = Bill::whereBetween('created_at', [$fromDate, $now]);

        if ($status !== null) {
            $query->where('status', $status);
        }

        $counts = $query
            ->selectRaw('DATE(created_at) as day, count(*) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return response()->json([
            'daily_counts' => $counts,
            'from' => $fromDate->toISOString(),
            'to' => $now->toISOString(),
            'status' => $status ?? 'all',
        ]);
    }


    public function minMaxBill(int $range = 30, ?string $status = null): JsonResponse
    {
        $now = Carbon::now();
        $fromDate = $now->copy()->subDays($range);

        $query = Bill::whereBetween('created_at', [$fromDate, $now]);

        if ($status !== null) {
            $query->where('status', $status);
        }

        $min = $query->min('total_sum');
        $max = $query->max('total_sum');

        return response()->json([
            'min' => $min,
            'max' => $max,
            'from' => $fromDate->toISOString(),
            'to' => $now->toISOString(),
            'status' => $status ?? 'all',
        ]);
    }
}
