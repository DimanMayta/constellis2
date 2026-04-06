<?php

namespace App\Filament\Pages;

use App\Events\NewIntranetMessage;
use App\Models\InternalMessage;
use App\Models\User;
use Filament\Pages\Page;
use Illuminate\Support\Str;

class Messages extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Messages';
    protected static ?string $title = 'Messages';
    protected static ?int $navigationSort = -1;
    protected static ?string $navigationGroup = null;

    protected static string $view = 'filament.pages.messages';

    public static function getNavigationBadge(): ?string
    {
        $count = InternalMessage::where('to_user_id', auth()->id())
            ->whereNull('read_at')
            ->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    /**
     * Get contacts list (non-admin users + other admins)
     */
    public function getContacts(): array
    {
        $currentUser = auth()->user();

        return User::where('id', '!=', $currentUser->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get()
            ->map(function ($contact) use ($currentUser) {
                $lastMessage = InternalMessage::where(function ($q) use ($currentUser, $contact) {
                    $q->where('from_user_id', $currentUser->id)->where('to_user_id', $contact->id);
                })->orWhere(function ($q) use ($currentUser, $contact) {
                    $q->where('from_user_id', $contact->id)->where('to_user_id', $currentUser->id);
                })->orderByDesc('created_at')->first();

                return [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'role' => $contact->role,
                    'department' => $contact->department,
                    'initial' => substr($contact->name, 0, 1),
                    'last_message' => $lastMessage ? Str::limit($lastMessage->body, 40) : null,
                    'last_message_time' => $lastMessage?->created_at?->diffForHumans(),
                    'last_message_ts' => $lastMessage?->created_at?->timestamp ?? 0,
                    'unread' => InternalMessage::where('from_user_id', $contact->id)
                        ->where('to_user_id', $currentUser->id)
                        ->whereNull('read_at')
                        ->count(),
                ];
            })
            ->sortByDesc('last_message_ts')
            ->values()
            ->toArray();
    }

    /**
     * Fetch messages for a conversation (AJAX endpoint)
     */
    public function fetchMessages(int $userId): array
    {
        $currentUser = auth()->user();

        // Mark received messages as read
        InternalMessage::where('from_user_id', $userId)
            ->where('to_user_id', $currentUser->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return InternalMessage::where(function ($q) use ($currentUser, $userId) {
            $q->where('from_user_id', $currentUser->id)->where('to_user_id', $userId);
        })->orWhere(function ($q) use ($currentUser, $userId) {
            $q->where('from_user_id', $userId)->where('to_user_id', $currentUser->id);
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
        })
        ->toArray();
    }

    /**
     * Send a message (AJAX endpoint)
     */
    public function sendReply(int $toUserId, string $body): array
    {
        $body = trim($body);
        if (empty($body)) return ['error' => 'Message cannot be empty'];

        $message = InternalMessage::create([
            'from_user_id' => auth()->id(),
            'to_user_id' => $toUserId,
            'body' => $body,
        ]);

        broadcast(new NewIntranetMessage($message->load('sender')))->toOthers();

        return [
            'id' => $message->id,
            'body' => $message->body,
            'is_mine' => true,
            'sender_name' => 'You',
            'time' => $message->created_at->format('g:i A'),
            'date' => $message->created_at->format('M d'),
            'read' => false,
        ];
    }
}
