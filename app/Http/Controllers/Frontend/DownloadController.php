<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\DownloadService;

class DownloadController extends Controller
{
    public function __construct(private DownloadService $downloadService)
    {
        
    }
    
    public function index()
    {
        return $this->downloadService->index();
    }
 
}
