<?php

namespace App\Services;

use App\Models\Visitor;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class VisitorService
{
    public function index()
    {
        try {
            $startDate = Carbon::now()->subDays(7);
            $endDate = Carbon::now()->subDays(1);

            $visitorCounts = Visitor::selectRaw('DATE(created_at) as visit_date, count(*) as visitors_count')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('visit_date')
                ->orderBy('visit_date')
                ->get();

            $allDays = [];
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $allDays[] = $date->format('Y-m-d');
            }

            $dailyVisitorCounts = [];
            foreach ($allDays as $index=>$day) {
                $foundVisitorCount = $visitorCounts->where('visit_date', $day)->first();
                $dailyVisitorCounts[$index] = $foundVisitorCount ? $foundVisitorCount->visitors_count : 0;
            }

            return response()->json($dailyVisitorCounts);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json($th->getMessage(), 500);
        }
    }

    public function store($request)
    {
        try {
            $data['user_ip'] = $request->ip();
            $cache_key = "visitor-entry:" . $data['user_ip'];

            // Cache::forget($cache_key);
            Cache::remember($cache_key, now()->addMinutes(20), function () use ($data) {
                Visitor::create($data);
            });
            return response()->json(["message" => "Visitor store successfully"]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json($th->getMessage(), 500);
        }
    }
}
