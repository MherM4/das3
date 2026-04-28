<div style="display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f0f2f5; font-family: Arial, sans-serif;">

    <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center;">

        <h2 style="color: #42b72a; margin-bottom: 10px;">Ստեղծել հաշիվ</h2>
        <p style="color: #606770; font-size: 15px; margin-bottom: 20px;">Այն արագ է և հեշտ:</p>

        @if($errors->any())
            <div style="background: #ffebe9; color: #d93025; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 13px; text-align: left;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/register" method="POST" style="display: flex; flex-direction: column; gap: 12px;">
            @csrf

            <input type="text" name="name" placeholder="Անուն" value="{{ old('name') }}" required
                   style="padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px; outline: none;">

            <input type="email" name="email" placeholder="Էլ․ հասցե" value="{{ old('email') }}" required
                   style="padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px; outline: none;">

            <input type="password" name="password" placeholder="Նոր գաղտնաբառ" required
                   style="padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px; outline: none;">

            <input type="password" name="password_confirmation" placeholder="Կրկնել գաղտնաբառը" required
                   style="padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px; outline: none;">

            <p style="font-size: 11px; color: #777; text-align: left; margin: 5px 0;">
                Սեղմելով Գրանցվել, դուք համաձայնվում եք մեր պայմաններին:
            </p>

            <button type="submit"
                    style="background-color: #42b72a; color: white; padding: 12px; border: none; border-radius: 6px; font-size: 18px; font-weight: bold; cursor: pointer; transition: background 0.3s;">
                Գրանցվել
            </button>
        </form>

        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #ddd;">

        <div style="font-size: 14px;">
            Արդեն ունե՞ք հաշիվ:
            <a href="{{ route('login') }}" style="color: #1877f2; text-decoration: none; font-weight: bold; font-size: 16px;">
                Մուտք գործել
            </a>
        </div>
    </div>

</div>
