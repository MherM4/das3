<x-app-layout>
    <div style="max-width: 800px; margin: 20px auto; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Նամակագրություններ</h2>
            <a href="{{ $trashedCount > 0 ? route('chat.trash') : '#' }}"
               style="text-decoration: none; font-weight: bold; padding: 5px 10px; border-radius: 5px;
               {{ $trashedCount > 0 ? 'color: #dc3545; border: 1px solid #dc3545;' : 'color: #ccc; border: 1px solid #ccc; pointer-events: none;' }}">
                Ջնջված չատեր ({{ $trashedCount }})
            </a>
        </div>

        <form action="{{ route('chat.index') }}" method="GET" style="margin-bottom: 20px; display: flex; gap: 10px;">
            <input type="text" name="search" placeholder="Որոնել օգտատերեր..." value="{{ request('search') }}" style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
            <button type="submit" style="padding: 8px 15px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">Որոնել</button>
        </form>

        @if(request()->filled('search'))
            <h4>Որոնման արդյունքներ՝</h4>
            @foreach($users as $user)
                <div style="padding: 10px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                    {{ $user->name }}
                    @if(array_key_exists($user->id, $existingChats))
                        <a href="{{ route('chat.show', $existingChats[$user->id]) }}" style="background: #6c757d; color: white; padding: 5px 10px; border-radius: 5px; text-decoration: none;">Գրել նամակ</a>
                    @else
                        <form action="{{ route('chat.start', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" style="background: #28a745; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;">Նամակագրություն սկսել</button>
                        </form>
                    @endif
                </div>
            @endforeach
        @else
            @forelse($chats as $chat)
                @php
                    $defaultName = $chat->users->where('id', '!=', auth()->id())->first()->name ?? 'Զրույց ' . $chat->id;
                @endphp
                <div style="padding: 15px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 10px; flex: 1;">
                        <a href="{{ route('chat.show', $chat->id) }}" id="link-{{ $chat->id }}" style="text-decoration: none; color: #333; font-weight: bold;">
                            {{ $chat->name ?? $defaultName }}
                        </a>

                        <input type="text" id="input-{{ $chat->id }}" value="{{ $chat->name ?? '' }}"
                               data-id="{{ $chat->id }}" style="display:none; padding: 5px; width: 200px;"
                               onblur="saveChatName(this)" onkeydown="if(event.key==='Enter') this.blur()">

                        <button onclick="editChat('{{ $chat->id }}')" style="background: none; border: none; cursor: pointer; font-size: 14px;">✏️</button>

                        <!-- Ջնջելու կոճակ -->
                        <button id="delete-name-{{ $chat->id }}" onclick="deleteChatName('{{ $chat->id }}', '{{ $defaultName }}')"
                                style="background: none; border: none; cursor: pointer; font-size: 14px; {{ $chat->name ? '' : 'display:none;' }}">
                            🗑️
                        </button>
                    </div>

                    <form action="{{ route('chat.destroy', $chat->id) }}" method="POST" onsubmit="return confirm('Համոզվա՞ծ եք։');">
                        @csrf @method('DELETE')
                        <button type="submit" style="background: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;">Ջնջել</button>
                    </form>
                </div>
            @empty
                <p style="text-align: center; color: #888; margin-top: 20px;">Դեռևս չունեք նամակագրություններ։</p>
            @endforelse
        @endif
    </div>

    <form id="renameForm" method="POST" style="display:none;">
        @csrf @method('PATCH')
        <input type="text" name="name" id="newName">
    </form>

    @vite(['resources/js/chat-index.js'])
</x-app-layout>
