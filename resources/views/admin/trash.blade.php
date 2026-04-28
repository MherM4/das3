@include('components.header')

<main style="max-width: 900px; margin: 30px auto; padding: 25px; font-family: sans-serif;">
    <h1 style="color: #333; margin-bottom: 25px;">🗑️ Աղբաման (Ջնջված գրառումներ)</h1>

    @if(session('success'))
        <div style="padding: 15px; background: #d4edda; color: #155724; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
        <thead>
        <tr style="background: #f8f9fa; border-bottom: 2px solid #eee; text-align: left;">
            <th style="padding: 15px;">Վերնագիր</th>
            <th style="padding: 15px;">Հեղինակ</th>
            <th style="padding: 15px;">Ջնջվել է</th>
            <th style="padding: 15px; text-align: right;">Գործողություն</th>
        </tr>
        </thead>
        <tbody>
        @forelse($posts as $post)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 15px;">{{ $post->title }}</td>
                <td style="padding: 15px;">{{ $post->user->name }}</td>
                <td style="padding: 15px; color: #999;">{{ $post->deleted_at->diffForHumans() }}</td>
                <td style="padding: 15px; text-align: right; display: flex; gap: 10px; justify-content: flex-end;">

                    <form action="{{ route('posts.restore', $post->id) }}" method="POST">
                        @csrf
                        <button type="submit" style="background: #28a745; color: white; border: none; padding: 7px 12px; border-radius: 6px; cursor: pointer; font-weight: bold;">
                            Վերականգնել
                        </button>
                    </form>

                    <form action="{{ route('posts.force_delete', $post->id) }}" method="POST" onsubmit="return confirm('Այս գրառումը և նկարները կջնջվեն ԸՆԴՄԻՇՏ։ Շարունակե՞լ։');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: #dc3545; color: white; border: none; padding: 7px 12px; border-radius: 6px; cursor: pointer; font-weight: bold;">
                            Ջնջել ընդմիշտ
                        </button>
                    </form>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="padding: 40px; text-align: center; color: #888; font-style: italic;">
                    Աղբամանը դատարկ է։
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</main>
