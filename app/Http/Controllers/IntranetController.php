<?php

namespace App\Http\Controllers;

use App\Events\NewIntranetMessage;
use App\Models\InternalMessage;
use App\Models\InternalAnnouncement;
use App\Models\InternalDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class IntranetController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $announcements = InternalAnnouncement::published()
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->take(10)->get();
        $unreadCount = $user->unreadMessagesCount();
        $recentMessages = InternalMessage::forUser($user->id)
            ->with('sender')
            ->orderByDesc('created_at')
            ->take(5)->get();
        $recentDocuments = InternalDocument::orderByDesc('created_at')->take(5)->get();

        return view('pages.intranet.dashboard', compact(
            'announcements', 'unreadCount', 'recentMessages', 'recentDocuments'
        ));
    }

    // ── WhatsApp-style Chat ──

    public function chat()
    {
        $currentUser = auth()->user();

        // Get all users except current user
        $contacts = User::where('id', '!=', $currentUser->id)
            ->where('is_active', true)
            ->orderBy('name')->get();

        // Enrich contacts with last message info
        $contacts = $contacts->map(function ($contact) use ($currentUser) {
            $lastMessage = InternalMessage::where(function ($q) use ($currentUser, $contact) {
                $q->where('from_user_id', $currentUser->id)->where('to_user_id', $contact->id);
            })->orWhere(function ($q) use ($currentUser, $contact) {
                $q->where('from_user_id', $contact->id)->where('to_user_id', $currentUser->id);
            })->orderByDesc('created_at')->first();

            $contact->last_message = $lastMessage;
            $contact->unread_from = InternalMessage::where('from_user_id', $contact->id)
                ->where('to_user_id', $currentUser->id)
                ->whereNull('read_at')
                ->count();
            return $contact;
        })->sortByDesc(function ($c) {
            return $c->last_message?->created_at ?? now()->subYears(10);
        })->values();

        return view('pages.intranet.chat', compact('contacts'));
    }

    public function chatContacts()
    {
        $currentUser = auth()->user();

        $contacts = User::where('id', '!=', $currentUser->id)
            ->where('is_active', true)
            ->orderBy('name')->get();

        $contacts = $contacts->map(function ($contact) use ($currentUser) {
            $lastMessage = InternalMessage::where(function ($q) use ($currentUser, $contact) {
                $q->where('from_user_id', $currentUser->id)->where('to_user_id', $contact->id);
            })->orWhere(function ($q) use ($currentUser, $contact) {
                $q->where('from_user_id', $contact->id)->where('to_user_id', $currentUser->id);
            })->orderByDesc('created_at')->first();

            return [
                'id' => $contact->id,
                'name' => $contact->name,
                'role' => $contact->role,
                'avatar' => $contact->avatar,
                'last_message' => $lastMessage?->body ? \Str::limit($lastMessage->body, 50) : null,
                'last_message_time' => $lastMessage?->created_at?->diffForHumans(),
                'unread' => InternalMessage::where('from_user_id', $contact->id)
                    ->where('to_user_id', $currentUser->id)
                    ->whereNull('read_at')
                    ->count(),
            ];
        })->sortByDesc(function ($c) {
            return $c['last_message_time'] ?? '';
        })->values();

        return response()->json($contacts);
    }

    public function fetchMessages(User $user)
    {
        $currentUser = auth()->user();

        // Mark all messages from this user as read
        InternalMessage::where('from_user_id', $user->id)
            ->where('to_user_id', $currentUser->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // Get conversation between the two users
        $messages = InternalMessage::where(function ($q) use ($currentUser, $user) {
            $q->where('from_user_id', $currentUser->id)->where('to_user_id', $user->id);
        })->orWhere(function ($q) use ($currentUser, $user) {
            $q->where('from_user_id', $user->id)->where('to_user_id', $currentUser->id);
        })->orderBy('created_at', 'asc')
        ->get()
        ->map(function ($msg) use ($currentUser) {
            return [
                'id' => $msg->id,
                'body' => $msg->body,
                'is_mine' => $msg->from_user_id === $currentUser->id,
                'sender_name' => $msg->from_user_id === $currentUser->id ? 'You' : ($msg->sender->name ?? 'Unknown'),
                'time' => $msg->created_at->format('g:i A'),
                'date' => $msg->created_at->format('M d'),
                'read' => $msg->read_at !== null,
            ];
        });

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'to_user_id' => 'required|exists:users,id',
            'body' => 'required|string|max:10000',
        ]);

        $message = InternalMessage::create([
            'from_user_id' => auth()->id(),
            'to_user_id' => $validated['to_user_id'],
            'body' => $validated['body'],
        ]);

        // Broadcast real-time notification via Reverb
        broadcast(new NewIntranetMessage($message->load('sender')))->toOthers();

        return response()->json([
            'id' => (int) $message->id,
            'body' => $message->body,
            'is_mine' => true,
            'sender_name' => 'You',
            'time' => $message->created_at->format('g:i A'),
            'date' => $message->created_at->format('M d'),
            'read' => false,
        ]);
    }

    // ── Announcements ──
    public function announcements()
    {
        $announcements = InternalAnnouncement::published()
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->paginate(15);
        return view('pages.intranet.announcements', compact('announcements'));
    }

    // ── Documents ──
    public function documents(Request $request)
    {
        $query = InternalDocument::orderByDesc('created_at');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $userLevel = auth()->user()->access_level;
        $levels = ['basic'];
        if ($userLevel === 'elevated') $levels[] = 'elevated';
        if ($userLevel === 'full') { $levels[] = 'elevated'; $levels[] = 'full'; }

        $query->whereIn('access_level', $levels);

        $documents = $query->paginate(20);
        return view('pages.intranet.documents', compact('documents'));
    }

    public function downloadDocument(InternalDocument $document)
    {
        $document->increment('download_count');
        return response()->download(storage_path('app/public/' . $document->file_path));
    }

    // ── Heartbeat / Online Presence ──

    /**
     * POST: Update current user's last_seen_at, return list of online user IDs.
     */
    public function heartbeat()
    {
        $user = auth()->user();
        $user->update(['last_seen_at' => now()]);

        $threshold = Carbon::now()->subSeconds(30);
        $onlineIds = User::where('is_active', true)
            ->where('last_seen_at', '>=', $threshold)
            ->pluck('id');

        return response()->json(['online' => $onlineIds]);
    }

    /**
     * GET: Poll for new messages since a given message ID.
     * Returns only new messages to avoid transferring the full conversation.
     */
    public function pollMessages(User $user, Request $request)
    {
        $currentUser = auth()->user();
        $afterId = (int) $request->query('after', 0);

        // Build base query for conversation
        $query = InternalMessage::where(function ($q) use ($currentUser, $user) {
            $q->where('from_user_id', $currentUser->id)->where('to_user_id', $user->id);
        })->orWhere(function ($q) use ($currentUser, $user) {
            $q->where('from_user_id', $user->id)->where('to_user_id', $currentUser->id);
        });

        if ($afterId > 0) {
            $query->where('id', '>', $afterId);
        }

        $messages = $query->orderBy('created_at', 'asc')->get();

        // Mark received messages as read
        InternalMessage::where('from_user_id', $user->id)
            ->where('to_user_id', $currentUser->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(
            $messages->map(function ($msg) use ($currentUser) {
                return [
                    'id' => (int) $msg->id,
                    'body' => $msg->body,
                    'is_mine' => $msg->from_user_id === $currentUser->id,
                    'sender_name' => $msg->from_user_id === $currentUser->id ? 'You' : ($msg->sender->name ?? 'Unknown'),
                    'time' => $msg->created_at->format('g:i A'),
                    'date' => $msg->created_at->format('M d'),
                    'read' => $msg->read_at !== null,
                ];
            })
        );
    }
}
