<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageSent;
use App\Http\Requests\SendMessageRequest;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{
    public function sendMessage(SendMessageRequest $request): JsonResponse
    {
        event(new ChatMessageSent($request->name, $request->message));

        return response()->json(['status' => 'Message sent successfully']);
    }
}
