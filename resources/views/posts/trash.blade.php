@include('components.header')

<main style="max-width: 1000px; margin: 30px auto; padding: 25px; font-family: 'Segoe UI', sans-serif;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 25px;">
        <h1 style="color: #333; margin: 0; font-size: 24px;">{{ $title }}</h1>
        <span style="background: #6c757d; color: white; padding: 5px 12px; border-radius: 20px; font-size: 14px; font-weight: bold;">
            {{ $posts->count() }} գրառում
        </span>
    </div>

    @if(session('success'))
        <div style="padding: 15px; background: #d4edda; color: #155724; border-radius: 10px; margin-bottom: 20px; border: 1px solid #c3e6cb; font-weight: 500;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 1px solid #eee;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
            <tr style="background: #f8f9fa; border-bottom: 2px solid #f1f1f1;">
                <th style="padding: 18px 15px; color: #555; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Վերնագիր</th>

                @if($title !== 'Իմ աղբամանը')
                    <th style="padding: 18px 15px; color: #555; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Հեղինակ</th>
                    <th style="padding: 18px 15px; color: #555; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Ջնջող</th>
                @endif

                <th style="padding: 18px 15px; color: #555; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Ջնջվել է</th>
                <th style="padding: 18px 15px; color: #555; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; text-align: right;">Գործողություն</th>
            </tr>
            </thead>
            <tbody>
            @forelse($posts as $post)
                <tr style="border-bottom: 1px solid #f9f9f9; transition: 0.2s;" onmouseover="this.style.background='#fcfcfc'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 15px;">
                        <strong style="color: #333; display: block; font-size: 15px;">{{ $post->title }}</strong>
                    </td>

                    @if($title !== 'Իմ աղբամանը')
                        <td style="padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <img src="{{ $post->user->avatar_url }}" style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover; border: 1px solid #eee;">
                                <span style="font-size: 14px; color: #333; font-weight: 500;">{{ $post->user->name }}</span>
                            </div>
                        </td>
                        <td style="padding: 15px;">
                            @if($post->deleter)
                                <span style="display: inline-block; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: bold;
                                    {{ $post->deleter->id === $post->user_id ? 'background: #e9ecef; color: #495057;' : 'background: #fff5f5; color: #e53e3e; border: 1px solid #feb2b2;' }}">
                                    {{ $post->deleter->id === $post->user_id ? '🏠 Հեղինակը' : '👮 ' . $post->deleter->name }}
                                </span>
                            @else
                                <span style="color: #ccc; font-size: 12px; font-style: italic;">Անհայտ</span>
                            @endif
                        </td>
                    @endif

                    <td style="padding: 15px; color: #888; font-size: 13px;">
                        <time title="{{ $post->deleted_at }}">{{ $post->deleted_at->diffForHumans() }}</time>
                    </td>

                    <td style="padding: 15px; text-align: right;">
                        <div style="display: flex; gap: 10px; justify-content: flex-end;">
                            <form action="{{ route('posts.restore', $post->id) }}" method="POST">
                                @csrf
                                <button type="submit" style="background: #28a745; color: white; border: none; padding: 7px 14px; border-radius: 8px; cursor: pointer; font-size: 12px; font-weight: bold; transition: 0.3s;"
                                        onmouseover="this.style.background='#218838'" onmouseout="this.style.background='#28a745'">
                                    Վերականգնել
                                </button>
                            </form>

                            <form action="{{ route('posts.force_delete', $post->id) }}" method="POST" onsubmit="return confirm('⚠️ ՈՒՇԱԴՐՈՒԹՅՈՒՆ: Այս գրառումը և նրա նկարները կջնջվեն ԸՆԴՄԻՇՏ։')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: white; color: #dc3545; border: 1px solid #dc3545; padding: 7px 14px; border-radius: 8px; cursor: pointer; font-size: 12px; font-weight: bold; transition: 0.3s;"
                                        onmouseover="this.style.background='#dc3545'; this.style.color='white'" onmouseout="this.style.background='white'; this.style.color='#dc3545'">
                                    Ջնջել ընդմիշտ
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $title !== 'Իմ աղբամանը' ? 5 : 3 }}" style="padding: 60px 20px; text-align: center; color: #adb5bd;">
                        <div style="font-size: 40px; margin-bottom: 10px;">🗑️</div>
                        <div style="font-size: 16px; font-weight: 500;">Աղբամանը դատարկ է</div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</main>

<style>
    button {display: inline-flex;align-items: center;justify-content: center;outline: none;}
    button:active {transform: scale(0.95);}
</style>
