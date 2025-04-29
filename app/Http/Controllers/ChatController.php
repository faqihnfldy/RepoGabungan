<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedUserId = $request->get('user_id');
        $messages = collect();
        
        // Ambil lawan chat sesuai role
        if ($user->role === 'user') {
            $users = User::where('role', 'doctor')->get();
        } else if ($user->role === 'doctor') {
            $users = User::where('role', 'user')->get();
        } else {
            $users = collect();
        }

        // Jika sudah memilih lawan chat, ambil pesan
        if ($selectedUserId) {
            $messages = ChatMessage::where(function($query) use ($user, $selectedUserId) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $selectedUserId);
            })->orWhere(function($query) use ($user, $selectedUserId) {
                $query->where('sender_id', $selectedUserId)
                      ->where('receiver_id', $user->id);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();
        }

        return view('chat.index', compact('messages', 'users', 'selectedUserId'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);

        $message = ChatMessage::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        return response()->json([
            'status' => 'success',
            'message' => $message->load('sender')
        ]);
    }

    public function getMessages($userId)
    {
        $user = Auth::user();
        $messages = ChatMessage::where(function($query) use ($user, $userId) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', $userId);
        })->orWhere(function($query) use ($user, $userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', $user->id);
        })
        ->with(['sender', 'receiver'])
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json($messages);
    }
}
