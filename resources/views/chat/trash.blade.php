<div style="max-width: 800px; margin: 20px auto; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
    <h2 style="border-bottom: 2px solid #f4f4f4; padding-bottom: 10px;">Ջնջված զրույցներ (Աղբաման)</h2>

    @forelse($trashedChats as $chat)
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; border-bottom: 1px solid #eee; transition: background 0.3s;">
            <span style="font-weight: 500;">{{ $chat->name ?? 'Զրույց ' . $chat->id }}</span>

            <div style="display: flex; gap: 10px;">
                <form action="{{ route('chat.restore', $chat->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit" style="background: #28a745; color: white; border: none; padding: 5px 12px; border-radius: 5px; cursor: pointer;">Վերականգնել</button>
                </form>

                <form action="{{ route('chat.forceDelete', $chat->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Հեռացնե՞լ ընդմիշտ։')" style="background: #dc3545; color: white; border: none; padding: 5px 12px; border-radius: 5px; cursor: pointer;">Ջնջել ընդմիշտ</button>
                </form>
            </div>
        </div>
    @empty
        <p style="text-align: center; color: #888; margin-top: 30px;">Աղբամանը դատարկ է։</p>
    @endforelse

    <a href="{{ route('chat.index') }}" style="display: inline-block; margin-top: 20px; color: #007bff; text-decoration: none;">← Վերադառնալ նամակներին</a>
</div>
