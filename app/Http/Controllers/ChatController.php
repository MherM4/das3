<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Chat;
use App\Models\User;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    use AuthorizesRequests;

public function index(Request $request)
{
    $query = $request->input('search');
    $users = collect();
    $existingChats = [];

    if ($query) {
        $users = User::where('name', 'like', "%{$query}%")
                     ->where('id', '!=', auth()->id())
                     ->get();

        $chats = auth()->user()->chats()
            ->whereHas('users', function($q) {
                $q->where('user_id', '!=', auth()->id());
            })->with('users')->get();

        foreach ($chats as $chat) {
            $otherUser = $chat->users->where('id', '!=', auth()->id())->first();
            if ($otherUser) {
                $existingChats[$otherUser->id] = $chat->id;
            }
        }
    }

    $trashedCount = auth()->user()->chats()->onlyTrashed()->count();
    $chats = auth()->user()->chats()->with('users')->latest()->get();

    return view('chat.index', compact('users', 'chats', 'trashedCount', 'existingChats'));
}

public function startChat($userId)
{
    $chat = \App\Models\Chat::whereHas('users', function ($query) use ($userId) {
        $query->where('user_id', $userId);
    })->whereHas('users', function ($query) {
        $query->where('user_id', auth()->id());
    })->first();

    if (!$chat) {
    $chat = \App\Models\Chat::create([
        'creator_id' => auth()->id()
    ]);

    $chat->users()->attach([auth()->id(), $userId]);
}

    return redirect()->route('chat.show', $chat->id);
}

    public function show(Chat $chat)
    {
        $this->authorize('view', $chat);
        $messages = $chat->messages()->whereNull('deleted_at')->get();
        return view('chat.chat', [
            'chat' => $chat,
            'messages' => $chat->messages()->with('user')->get()
        ]);
    }

    public function sendMessage(StoreMessageRequest $request)
{
    $chat = Chat::findOrFail($request->chat_id);
    $this->authorize('view', $chat);

    $message = Message::create([
        'user_id' => auth()->id(),
        'chat_id' => $chat->id,
        'content' => $request->content,
        'type' => $request->hasFile('file') ? $request->file('file')->getClientMimeType() : 'text',
        'file_path' => $request->hasFile('file') ? $request->file('file')->store('chat_files', 'public') : null,
    ]);

    $message->load('user');

    broadcast(new \App\Events\MessageSent($message))->toOthers();

    return response()->json($message);
}

    public function updateMessage(UpdateMessageRequest $request, Message $message)
    {
        $this->authorize('update', $message);

        $message->update([
            'content' => $request->validated()['content'],
            'is_edited' => true
        ]);

        return response()->json(['message' => 'Updated successfully']);
    }

    public function destroyMessage(Message $message)
    {
        $this->authorize('delete', $message);
        $message->delete();
        return response()->json(['message' => 'Deleted']);
    }

    public function destroy($id)
{
    $chat = \App\Models\Chat::findOrFail($id);
    $this->authorize('delete', $chat);
    $chat->delete();
    return redirect()->route('chat.index')->with('success', 'Զրույցը տեղափոխվեց աղբաման');
}

    public function setAdmin(Request $request, Chat $chat, $userId)
    {
        $this->authorize('setAdmin', $chat);
        $chat->users()->updateExistingPivot($userId, ['role' => 'admin']);
        return response()->json(['message' => 'User promoted to admin']);
    }

public function trash()
{    $trashedChats = auth()->user()->chats()->onlyTrashed()->latest()->get();
    return view('chat.trash', compact('trashedChats'));
}

public function restore($id)
{
    $chat = \App\Models\Chat::onlyTrashed()->findOrFail($id);
    $chat->restore();
    return redirect()->route('chat.trash')->with('success', 'Զրույցը վերականգնվեց');
}

public function forceDelete($id)
{ $chat = \App\Models\Chat::onlyTrashed()->findOrFail($id);
    $chat->messages()->forceDelete();
    $chat->forceDelete();
    return redirect()->route('chat.trash')->with('success', 'Զրույցը հեռացվեց ընդմիշտ');
}

public function updateName(Request $request, $id)
{    $request->validate(['name' => 'required|string|max:255']);
    $chat = \App\Models\Chat::findOrFail($id);
    $chat->update(['name' => $request->name]);
    return back();
}
public function removeName($id)
{
    $chat = \App\Models\Chat::findOrFail($id);
    $chat->update(['name' => null]);
    return response()->json(['success' => true]);
}
}
