<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Services\VisitorService;
use App\Http\Controllers\Controller;

class VisitorController extends Controller
{
    public function __construct(private VisitorService $visitorService)
    {
        
    }
    public function index()
    {
        return $this->visitorService->index();
    }

    public function store(Request $request)
    {
        return $this->visitorService->store($request);
    }
}
