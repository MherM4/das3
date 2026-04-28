<div style="display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f0f2f5; font-family: Arial, sans-serif;">

    <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center;">

        <h2 style="color: #1877f2; margin-bottom: 20px;">Մուտք</h2>

        @if(session('success'))
            <div style="background: #e7f3ff; color: #1877f2; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: #ffebe9; color: #d93025; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px; text-align: left;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/login" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            @csrf
            <input type="email" name="email" placeholder="Էլ․ հասցե" required
                   style="padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; outline: none;">

            <input type="password" name="password" placeholder="Գաղտնաբառ" required
                   style="padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; outline: none;">

            <button type="submit"
                    style="background-color: #1877f2; color: white; padding: 12px; border: none; border-radius: 6px; font-size: 18px; font-weight: bold; cursor: pointer; transition: background 0.3s;">
                Մուտք գործել
            </button>
        </form>

        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #ddd;">

        <div style="font-size: 14px;">
            Դեռ հաշիվ չունե՞ք:
            <a href="{{ route('register') }}" style="color: #42b72a; text-decoration: none; font-weight: bold; font-size: 16px;">
                Գրանցվել նոր հաշիվ
            </a>
        </div>
    </div>

</div>
