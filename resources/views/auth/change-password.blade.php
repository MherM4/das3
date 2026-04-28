@include('components.header')

<main style="display: flex; justify-content: center; align-items: center; min-height: 80vh; background-color: #f0f2f5;">
    <div style="background: white; width: 100%; max-width: 400px; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; margin-bottom: 25px;">Փոխել գաղտնաբառը</h2>

        @if($errors->any())
            <div style="color: red; margin-bottom: 15px; font-size: 14px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Ընթացիկ գաղտնաբառ</label>
                <input type="password" name="current_password" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Նոր գաղտնաբառ</label>
                <input type="password" name="new_password" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px;">Հաստատել նոր գաղտնաբառը</label>
                <input type="password" name="new_password_confirmation" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>

            <button type="submit" style="width: 100%; background: #007bff; color: white; border: none; padding: 12px; border-radius: 6px; cursor: pointer; font-weight: bold;">
                Թարմացնել գաղտնաբառը
            </button>

            <a href="{{ route('profile') }}" style="display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none; font-size: 14px;">Չեղարկել</a>
        </form>
    </div>
</main>
