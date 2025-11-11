<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// use App\Events\NewMessageEvent;

class ConversationApiController extends Controller
{
    /**
     * List conversations for the authenticated user.
     */
    public function index()
    {
        $userId = Auth::id();
        
        $conversations = Conversation::forUser($userId)
            ->with(['client', 'vendor', 'product.store'])
            ->withCount(['messages' => function ($query) use ($userId) {
                $query->where('sender_id', '!=', $userId)
                      ->where('is_read', false);
            }])
            ->with(['messages' => function ($query) {
                $query->latest()->take(10);
            }])
            ->orderByDesc('last_message_at')
            ->paginate(10);

        return response()->json([
            'conversations' => $conversations,
        ], 200);
    }

    /**
     * Start a new conversation.
     */
    public function startConversation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|exists:users,id',
            'product_id' => 'nullable|exists:products,id',
            'message' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $client = Auth::user();

        // Verify vendor
        $vendor = User::where('id', $request->vendor_id)
            ->where('user_type', 'vendor')
            ->firstOrFail();

        // Verify product belongs to vendor's store
        if ($request->product_id) {
            Product::where('id', $request->product_id)
                ->whereHas('store', function ($query) use ($request) {
                    $query->where('vendor_id', $request->vendor_id);
                })->firstOrFail();
        }

        // Find or create conversation
        $conversation = Conversation::firstOrCreate(
            [
                'client_id' => $client->id,
                'vendor_id' => $request->vendor_id,
                'product_id' => $request->product_id,
            ],
            ['last_message_at' => now()]
        );

        // If conversation already exists, just return it
        if (!$conversation->wasRecentlyCreated) {
            $conversation->load(['messages.sender', 'product.store', 'client', 'vendor']);
            return response()->json([
                'message' => 'Conversation retrieved',
                'conversation' => $conversation,
            ], 200);
        }

        // Create initial message only if provided
        if (($request->message && $request->message !== '') || $request->hasFile('image')) {
            $path = null;
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('images/messages', 'public');
            }

            $message = $conversation->messages()->create([
                'sender_id' => $client->id,
                'message' => $request->message,
                'image' => $path,
            ]);

            $conversation->update(['last_message_at' => now()]);

            // Broadcast event (comment out if NewMessageEvent doesn't exist)
            // broadcast(new NewMessageEvent($message))->toOthers();
        }

        $conversation->load(['messages.sender', 'product.store', 'client', 'vendor']);

        return response()->json([
            'message' => 'Conversation started',
            'conversation' => $conversation,
        ], 201);
    }

    /**
     * Send a message in a conversation.
     */
    public function sendMessage(Request $request, $conversationId)
    {
        $conversation = Conversation::forUser(Auth::id())->findOrFail($conversationId);

        $validator = Validator::make($request->all(), [
            'message' => 'required_without:image|string|nullable',
            'image' => 'required_without:message|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/messages', 'public');
        }

        $message = $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'image' => $path,
        ]);

        $conversation->update(['last_message_at' => now()]);

        // Broadcast event (comment out if NewMessageEvent doesn't exist)
        // broadcast(new NewMessageEvent($message))->toOthers();

        return response()->json([
            'status' => 'Message sent',
            'data' => $message->load('sender'),
        ], 201);
    }

    /**
     * Fetch messages for a conversation.
     */
    public function getMessages($conversationId)
    {
        $conversation = Conversation::forUser(Auth::id())
            ->with(['messages.sender', 'product.store', 'client', 'vendor'])
            ->findOrFail($conversationId);

        // Mark messages as read
        $conversation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'conversation' => $conversation,
            'messages' => $conversation->messages()->with('sender')->orderBy('created_at')->paginate(20),
        ], 200);
    }
}