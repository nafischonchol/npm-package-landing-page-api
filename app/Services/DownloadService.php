<?php

namespace App\Services;

use App\Models\DownloadHistory;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DownloadService
{
    public function index()
    {
        try {

            $this->store();

            $startDate = Carbon::now()->subDays(7)->format("Y-m-d");
            $endDate = Carbon::now()->subDays(1)->format("Y-m-d");

            $downloadCounts = DownloadHistory::selectRaw('date, total_download')
                ->whereBetween('date', [$startDate, $endDate])
                ->orderBy('date')
                ->get()
                ->pluck('total_download', 'date'); 

            $allDays = [];
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $allDays[] = $date->format("Y-m-d");
            }

            $dailyDownloadCounts = [];
            foreach ($allDays as $index => $day) {
                $dailyDownloadCounts[$index] = $downloadCounts->has($day) ? $downloadCounts[$day] : 0;
            }

            return response()->json($dailyDownloadCounts);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json($th->getMessage(), 500);
        }
    }

    public function store()
    {
        $today = now()->toDateString();
        $cache_key = "download:" . $today;

        // Cache::forget($cache_key);
        Cache::remember($cache_key, now()->addMinutes(5), function () {

            $end_point = "/downloads/point/last-day/react-api-call";

            $base_url = "https://api.npmjs.org";

            $client = new Client([
                'base_uri' => $base_url,
                'timeout' => 2.0,
            ]);

            $response = $client->request('GET', $end_point);
            $result = json_decode($response->getBody()->getContents(), true);
            $isExist = DownloadHistory::where("date", $result['start'])->exists();

            if (!$isExist) {
                DownloadHistory::create([
                    "date" => $result['start'],
                    "total_download" => $result['downloads'],
                ]);
            }
        });
    }
}
