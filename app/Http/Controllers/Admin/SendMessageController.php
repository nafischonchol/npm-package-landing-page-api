<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SendMessageService;

class SendMessageController extends Controller
{
    public function __construct(private SendMessageService $sendMessageService)
    {
        
    }

    public function index(Request $request)
    {
        return $this->sendMessageService->index($request);
    }
}
