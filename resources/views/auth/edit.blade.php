@include('components.header')

<main style="max-width: 600px; margin: 50px auto; padding: 20px; font-family: sans-serif;">
    <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); text-align: center;">

        <h2 style="margin-bottom: 30px; color: #333;">Խմբագրել պրոֆիլը</h2>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="position: relative; display: inline-block; margin-bottom: 30px;">
                <img src="{{ auth()->user()->avatar_url }}" style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover; border: 3px solid #007bff;">
                <label for="avatar" style="position: absolute; bottom: 5px; right: 5px; background: #007bff; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 3px solid white;">
                    <span style="font-size: 20px;">+</span>
                </label>
                <input type="file" id="avatar" name="avatar" style="display: none;">
            </div>

            <div style="text-align: left; margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #555;">Ամբողջական անուն</label>
                <input type="text" name="name" value="{{ auth()->user()->name }}" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px;">
            </div>

            <div style="text-align: left; margin-bottom: 30px;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #555;">Էլ. հասցե</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; background: #f9f9f9;">
            </div>

            <button type="submit" style="width: 100%; background: #007bff; color: white; border: none; padding: 14px; border-radius: 10px; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s;">
                Պահպանել փոփոխությունները
            </button>
        </form>

        @if(auth()->user()->avatar)
            <form action="{{ route('avatar.delete') }}" method="POST" style="margin-top: 15px;">
                @csrf
                <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; font-size: 14px;">
                    🗑️ Ջնջել պրոֆիլի նկարը
                </button>
            </form>
        @endif

        <hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">

        <a href="{{ route('password.edit') }}" style="text-decoration: none; color: #007bff; font-weight: bold; display: flex; align-items: center; justify-content: center; gap: 8px;">
            🔐 Փոխել գաղտնաբառը
        </a>
    </div>
</main>
