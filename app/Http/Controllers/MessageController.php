<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Church;
use App\Events\NewMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display the messages inbox.
     */
    public function index(Request $request)
    {
        $churchId = Auth::user()->church_id;
        $user = Auth::user();
        
        // Get all churches except the current user's church
        $churches = Church::where('id', '!=', $churchId)
                         ->orderBy('name')
                         ->get();
        
        // Build query based on filter
        $query = Message::where(function($q) use ($churchId) {
            $q->where('sender_church_id', $churchId)
              ->orWhere('receiver_church_id', $churchId);
        });
        
        // Apply filters
        if ($request->type === 'sent') {
            $query->where('sender_church_id', $churchId);
        } elseif ($request->type === 'unread') {
            $query->where('receiver_church_id', $churchId)
                  ->where('is_read', false);
        } else {
            // Inbox - show received messages
            $query->where('receiver_church_id', $churchId);
        }
        
        $messages = $query->with(['sender', 'receiver'])
                         ->orderBy('created_at', 'desc')
                         ->paginate(20);
        
        // Get unread count
        $unreadCount = Message::where('receiver_church_id', $churchId)
                             ->where('is_read', false)
                             ->count();
        
        // Get all churches with unread count
        $allChurches = Church::where('id', '!=', $churchId)
                            ->orderBy('name')
                            ->get();
        
        // Add unread count to each church
        foreach ($allChurches as $church) {
            $church->unread_count = Message::where('sender_church_id', $church->id)
                                          ->where('receiver_church_id', $churchId)
                                          ->where('is_read', false)
                                          ->count();
        }
        
        return view('messages.index', compact('messages', 'unreadCount', 'churches', 'allChurches', 'user'));
    }

    /**
     * Show the compose form.
     */
    public function create()
    {
        $churchId = Auth::user()->church_id;
        $churches = Church::where('id', '!=', $churchId)
                         ->orderBy('name')
                         ->get();
        
        return view('messages.create', compact('churches'));
    }

    /**
     * Show a single message.
     */
    public function show($id)
    {
        $churchId = Auth::user()->church_id;
        
        $message = Message::where(function($query) use ($churchId) {
                            $query->where('sender_church_id', $churchId)
                                  ->orWhere('receiver_church_id', $churchId);
                        })
                        ->with(['sender', 'receiver'])
                        ->findOrFail($id);
        
        // Mark as read if receiver
        if ($message->receiver_church_id == $churchId && !$message->is_read) {
            $message->markAsRead();
        }
        
        return view('messages.show', compact('message'));
    }

    /**
     * Send a new message.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'receiver_church_id' => 'required|exists:churches,id',
                'subject' => 'nullable|string|max:255',
                'body' => 'required|string|min:1',
            ]);

            $churchId = Auth::user()->church_id;
            $user = Auth::user();

            if (!$churchId) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not associated with a church.'
                ], 400);
            }

            $message = Message::create([
                'sender_church_id' => $churchId,
                'receiver_church_id' => $request->receiver_church_id,
                'subject' => $request->subject ?: 'No Subject',
                'body' => $request->body,
                'is_read' => false,
            ]);

            // Load relationships
            $message->load(['sender', 'receiver']);

            // Broadcast the new message
            try {
                broadcast(new NewMessage($message));
            } catch (\Exception $e) {
                \Log::error('Broadcast failed: ' . $e->getMessage());
            }

            // Check if request is AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => [
                        'id' => $message->id,
                        'sender_name' => $user->church->name ?? 'You',
                        'sender_church_id' => $churchId,
                        'receiver_church_id' => $request->receiver_church_id,
                        'subject' => $message->subject,
                        'body' => $message->body,
                        'is_read' => false,
                        'created_at' => now()->toDateTimeString(),
                        'created_at_diff' => 'Just now',
                        'is_own' => true,
                    ]
                ]);
            }

            return redirect()->route('messages.index')
                            ->with('success', 'Message sent successfully!');
                            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . implode(', ', array_merge(...array_values($e->errors()))),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Message send error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get messages for a specific church (conversation view).
     */
    public function conversation($churchId)
    {
        try {
            $myChurchId = Auth::user()->church_id;
            
            if (!$myChurchId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User has no church associated.'
                ], 400);
            }
            
            $messages = Message::where(function($q) use ($myChurchId, $churchId) {
                                $q->where('sender_church_id', $myChurchId)
                                  ->where('receiver_church_id', $churchId);
                            })
                            ->orWhere(function($q) use ($myChurchId, $churchId) {
                                $q->where('sender_church_id', $churchId)
                                  ->where('receiver_church_id', $myChurchId);
                            })
                            ->with(['sender', 'receiver'])
                            ->orderBy('created_at', 'asc')
                            ->get();
            
            // Mark messages from this church as read
            Message::where('sender_church_id', $churchId)
                   ->where('receiver_church_id', $myChurchId)
                   ->where('is_read', false)
                   ->update([
                       'is_read' => true,
                       'read_at' => now()
                   ]);
            
            $otherChurch = Church::find($churchId);
            
            return response()->json([
                'success' => true,
                'messages' => $messages,
                'other_church' => $otherChurch,
                'other_church_name' => $otherChurch?->name ?? 'Unknown Church'
            ]);
        } catch (\Exception $e) {
            \Log::error('Conversation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load messages: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark a message as read.
     */
    public function markRead($id)
    {
        $churchId = Auth::user()->church_id;
        
        $message = Message::where('receiver_church_id', $churchId)
                         ->findOrFail($id);
        
        $message->markAsRead();
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->back()->with('success', 'Message marked as read.');
    }

    /**
     * Mark all messages as read.
     */
    public function markAllRead()
    {
        $churchId = Auth::user()->church_id;
        
        Message::where('receiver_church_id', $churchId)
              ->where('is_read', false)
              ->update([
                  'is_read' => true,
                  'read_at' => now()
              ]);
        
        return redirect()->route('messages.index')
                        ->with('success', 'All messages marked as read.');
    }

    /**
     * Get unread message count.
     */
    public function unreadCount()
    {
        $churchId = Auth::user()->church_id;
        
        $count = Message::where('receiver_church_id', $churchId)
                       ->where('is_read', false)
                       ->count();
        
        return response()->json(['unread_count' => $count]);
    }

    /**
     * Archive a message.
     */
    public function archive($id)
    {
        $churchId = Auth::user()->church_id;
        
        $message = Message::where(function($query) use ($churchId) {
                            $query->where('sender_church_id', $churchId)
                                  ->orWhere('receiver_church_id', $churchId);
                        })
                        ->findOrFail($id);
        
        $message->update(['is_archived' => true]);
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('messages.index')
                        ->with('success', 'Message archived.');
    }

    /**
     * Delete a message.
     */
    public function destroy($id)
    {
        $churchId = Auth::user()->church_id;
        
        $message = Message::where(function($query) use ($churchId) {
                            $query->where('sender_church_id', $churchId)
                                  ->orWhere('receiver_church_id', $churchId);
                        })
                        ->findOrFail($id);
        
        $message->delete();
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('messages.index')
                        ->with('success', 'Message deleted.');
    }
}