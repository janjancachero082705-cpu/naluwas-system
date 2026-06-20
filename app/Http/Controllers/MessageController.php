<?php

namespace App\Http\Controllers;

use App\Models\Church;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Get messages for the current church
     */
    public function index(Request $request)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $messages = Message::where('receiver_church_id', $churchId)
            ->orWhere('church_id', $churchId)
            ->orderBy('created_at', 'desc')
            ->with(['church', 'sender', 'receiverChurch'])
            ->paginate(30);
        
        $unreadCount = Message::where('receiver_church_id', $churchId)
            ->where('is_read', false)
            ->count();
        
        $churches = Church::where('is_active', true)
            ->where('id', '!=', $churchId)
            ->get();

        return view('messages.index', compact('messages', 'unreadCount', 'churches'));
    }

    /**
     * Send a new message
     */
    public function store(Request $request)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        $userId = auth()->user()->id;

        $request->validate([
            'receiver_church_id' => 'required|exists:churches,id',
            'message' => 'required|string|max:5000',
            'title' => 'nullable|string|max:255',
            'type' => 'nullable|in:announcement,private,general',
        ]);

        $message = Message::create([
            'church_id' => $churchId,
            'sender_id' => $userId,
            'receiver_church_id' => $request->receiver_church_id,
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type ?? 'general',
            'is_read' => false,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully!',
                'data' => $message->load(['church', 'sender'])
            ]);
        }

        return redirect()->back()->with('success', 'Message sent successfully!');
    }

    /**
     * Mark a message as read
     */
    public function markAsRead($id)
    {
        $message = Message::findOrFail($id);
        
        // Only allow if the message belongs to this church
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        if ($message->receiver_church_id == $churchId) {
            $message->markAsRead();
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Marked as read'
            ]);
        }

        return redirect()->back();
    }

    /**
     * Get unread count via AJAX
     */
    public function getUnreadCount()
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $count = Message::where('receiver_church_id', $churchId)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'count' => $count
        ]);
    }

    /**
     * Get latest messages via AJAX
     */
    public function getLatest(Request $request)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        $lastId = $request->get('last_id', 0);

        $messages = Message::where('receiver_church_id', $churchId)
            ->orWhere('church_id', $churchId)
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'desc')
            ->with(['church', 'sender', 'receiverChurch'])
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }
}