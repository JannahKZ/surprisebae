<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        // Show all conversations admin has
        $adminId = auth()->id();

        $conversations = Conversation::where('admin_id', $adminId)
                            ->with('customer')
                            ->latest()
                            ->get();

        return view('chat.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        // Check admin owns this conversation for security
        $this->authorize('view', $conversation);

        $messages = $conversation->messages()->with('sender')->get();

        return view('chat.show', compact('conversation', 'messages'));
    }

    public function sendMessage(Request $request, Conversation $conversation)
    {
        $request->validate(['body' => 'required|string']);

        $message = ChatMessage::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'admin',
            'sender_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return redirect()->route('chat.show', $conversation->id);
    }

    public function getMessages($userId, $adminId)
    {
        $messages= Message::where(function ($query) use ($userId, $adminId) {
            $query->where('sender_id', $userId)->where('receiver_id', $adminId);
        })->orWhere(function ($query) use ($userId, $adminId) {
            $query->where('sender_id', $adminId)->where('receiver_id', $userId);
        })->orderBy('created_at')->get();

        return response()->json($messages);
    }



    public function apiPostMessage(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'seller_id' => 'required|integer',
            'message' => 'required|string',
        ]);

        $userId = $request->user_id;
        $sellerId = $request->seller_id;
        $messageBody = $request->message;

        // Find or create a conversation between these two users
        $conversation = Conversation::firstOrCreate(
            ['customer_id' => $userId, 'admin_id' => $sellerId],
            // Optionally add other defaults
        );

        // Create the chat message
        $chatMessage = ChatMessage::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'customer', // or 'admin' depending on sender role
            'sender_id' => $userId,
            'body' => $messageBody,
        ]);

        return response()->json(['success' => true, 'message' => 'Message sent successfully'], 201);
    }

}
