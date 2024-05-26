<?php

namespace App\Services;

use App\Models\SendMessage;
use Illuminate\Support\Facades\Log;

class SendMessageService
{
    public function index($request)
    {
        try {
            $messages  = SendMessage::latest('id')->paginate($request->input("per_page",20));
            return response()->json($messages);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json($th->getMessage(), 500);
        }
    }

    public function store($request)
    {
        try {
            SendMessage::create($request->validated());
            return response()->json(["message" => "Message store successfully!"]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json($th->getMessage(), 500);
        }
    }
}
