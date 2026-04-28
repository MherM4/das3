@include('components.header')

<main style="max-width: 1200px; margin: 30px auto; padding: 20px; font-family: sans-serif;">
    <h1 style="margin-bottom: 30px; color: #333;">Կառավարման վահանակ (Dashboard)</h1>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px;">

        <div style="background: #4e73df; color: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <div style="font-size: 14px; text-transform: uppercase; opacity: 0.8;">Ընդհանուր Օգտատերեր</div>
            <div style="font-size: 32px; font-weight: bold;">{{ $stats['users_count'] }}</div>
        </div>

        <div style="background: #1cc88a; color: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <div style="font-size: 14px; text-transform: uppercase; opacity: 0.8;">Գրառումներ</div>
            <div style="font-size: 32px; font-weight: bold;">{{ $stats['posts_count'] }}</div>
        </div>

        <div style="background: #f6c23e; color: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <div style="font-size: 14px; text-transform: uppercase; opacity: 0.8;">Ադմինիստրացիա</div>
            <div style="font-size: 32px; font-weight: bold;">{{ $stats['admins_count'] }}</div>
        </div>

        <div style="background: #e74a3b; color: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <div style="font-size: 14px; text-transform: uppercase; opacity: 0.8;">Բլոկվածներ</div>
            <div style="font-size: 32px; font-weight: bold;">{{ $stats['blocked_users'] }}</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <h3 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px;">Վերջին գրանցվածները</h3>
            <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                @foreach($latest_users as $u)
                    <tr style="border-bottom: 1px solid #f9f9f9;">
                        <td style="padding: 10px 0;">
                            <img src="{{ $u->avatar_url }}" style="width: 35px; height: 35px; border-radius: 50%; vertical-align: middle; margin-right: 10px;">
                            <strong>{{ $u->name }}</strong>
                        </td>
                        <td style="color: #888; font-size: 13px;">{{ $u->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
            </table>
            <a href="{{ route('admin.users') }}" style="display: block; margin-top: 20px; color: #4e73df; text-decoration: none; font-weight: bold; font-size: 14px;">Տեսնել բոլորին →</a>
        </div>

        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <h3 style="margin-top: 0;">Գործողություններ</h3>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <a href="{{ route('admin.users') }}" style="padding: 12px; background: #f8f9fc; border-radius: 8px; text-decoration: none; color: #333; font-weight: 500;">👤 Օգտատերերի կառավարում</a>
                <a href="/admin/posts" style="padding: 12px; background: #f8f9fc; border-radius: 8px; text-decoration: none; color: #333; font-weight: 500;">📝 Բոլոր գրառումները</a>
                @if(auth()->user()->role === 'super_admin')
                    <a href="#" style="padding: 12px; background: #fef1f0; border-radius: 8px; text-decoration: none; color: #e74a3b; font-weight: bold;">⚙️ Համակարգի կարգավորումներ</a>
                @endif
            </div>
        </div>
    </div>
</main>
