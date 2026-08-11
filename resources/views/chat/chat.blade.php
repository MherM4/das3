<x-app-layout>
    @vite(['resources/js/chat.js'])
    <div class="chat-wrapper"
        style="max-width: 600px; margin: 20px auto; background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); overflow: hidden; display: flex; flex-direction: column; height: 80vh;">

        <div style="padding: 15px; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 15px;">
            <a href="{{ route('chat.index') }}" style="text-decoration: none; color: #555;">←</a>
            <h3 style="margin: 0;">{{ $chat->name ?? 'Զրույց' }}</h3>
        </div>

        <div id="chat-messages"
            style="flex: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 15px; background: #fdfdfd;">
            @foreach ($messages as $message)
                <div id="msg-{{ $message->id }}" class="message-row"
                    style="display: flex; flex-direction: column; align-items: flex-end; margin-bottom: 15px; position: relative;">
                    <span
                        style="font-size: 11px; color: #777; margin-bottom: 2px;">{{ $message->user->name ?? '' }}</span>

                    <div style="display: flex; align-items: center; gap: 5px;">
                        <div style="background: #007bff; color: white; padding: 10px 15px; border-radius: 18px;">
                            <p id="msg-{{ $message->id }}-text" style="margin:0;">{{ $message->content }}</p>
                        </div>

                        @if ($message->user_id === auth()->id())
                            <button onclick="toggleMenu({{ $message->id }}, event)"
                                style="background: none; border: none; cursor: pointer; font-size: 16px;">⋮</button>
                        @endif
                    </div>

                    @if ($message->user_id === auth()->id())
                        <div id="menu-{{ $message->id }}"
                            style="display: none; position: absolute; top: 25px; right: 0; background: white; border: 1px solid #ccc; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.15); z-index: 10; padding: 5px;">
                            <button onclick="editMsg({{ $message->id }})"
                                style="display: block; width: 100%; text-align: left; background: none; border: none; padding: 5px 10px; cursor: pointer;">Խմբագրել</button>
                            <button onclick="deleteMsg({{ $message->id }})"
                                style="display: block; width: 100%; text-align: left; background: none; border: none; padding: 5px 10px; color: red; cursor: pointer;">Ջնջել</button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div style="padding: 15px; border-top: 1px solid #eee; display: flex; gap: 10px;">
            <input type="text" id="message-input"
                style="flex: 1; padding: 12px; border-radius: 25px; border: 1px solid #ddd; outline: none;"
                placeholder="Գրեք հաղորդագրություն...">
            <button onclick="sendMsg()"
                style="padding: 10px 20px; border-radius: 25px; background: #007bff; color: white; border: none; cursor: pointer;">Ուղարկել</button>
        </div>
    </div>

    <script>
        window.chatId = {{ $chat->id }};

        function toggleMenu(id) {
            const menu = document.getElementById(`menu-${id}`);
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }
    </script>
</x-app-layout>
