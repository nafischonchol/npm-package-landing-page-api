<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\SendMessageService;
use App\Http\Requests\Frontend\SendMessageRequest;

class SendMessageController extends Controller
{
    public function __construct(private SendMessageService $sendMessageService)
    {
        
    }

    public function store(SendMessageRequest $request)
    {
        return $this->sendMessageService->store($request);
    }
}
