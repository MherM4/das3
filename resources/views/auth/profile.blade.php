@include('components.header')

<main style="display: flex; justify-content: center; align-items: center; min-height: 80vh; background-color: #f0f2f5; padding: 20px; font-family: sans-serif;">

    <div style="background: white; width: 100%; max-width: 450px; padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); text-align: center;">

        <h2 style="margin-bottom: 25px; color: #333;">Իմ պրոֆիլը</h2>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-size: 14px;">
                {{ session('success') }}
            </div>
        @endif

        <form action="/profile" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="position: relative; display: inline-block; margin-bottom: 20px;">
                <img src="{{ $user->avatar_url }}" alt="Avatar"
                     style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover; border: 4px solid #007bff; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">

                <label for="avatar-input" style="position: absolute; bottom: 5px; right: 5px; background: #007bff; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 2px solid white; font-size: 20px;" title="Փոխել նկարը">
                    +
                </label>
                <input id="avatar-input" type="file" name="avatar" style="display: none;" onchange="this.form.submit()">
            </div>

            <div style="margin-bottom: 20px; text-align: left;">
                <label style="display: block; margin-bottom: 8px; color: #555; font-weight: bold; font-size: 14px;">Ամբողջական անուն</label>
                <input type="text" name="name" value="{{ $user->name }}"
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; outline: none; transition: border 0.3s;">
            </div>

            <div style="margin-bottom: 30px; text-align: left;">
                <label style="display: block; margin-bottom: 8px; color: #555; font-weight: bold; font-size: 14px;">Էլ. հասցե</label>
                <input type="text" value="{{ $user->email }}" disabled
                       style="width: 100%; padding: 12px; border: 1px solid #eee; border-radius: 8px; font-size: 16px; background: #f9f9f9; color: #888; cursor: not-allowed;">
            </div>

            <button type="submit" style="width: 100%; background: #007bff; color: white; border: none; padding: 14px; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background 0.3s;">
                Պահպանել փոփոխությունները
            </button>
        </form>

        @if($user->avatar)
            <form action="{{ route('avatar.delete') }}" method="POST" style="margin-top: 15px;">
                @csrf
                <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; font-size: 13px; text-decoration: none;">
                    🗑️ Ջնջել պրոֆիլի նկարը
                </button>
            </form>
        @endif

        <div style="margin-top: 25px; border-top: 1px solid #eee; padding-top: 20px;">
            <a href="{{ route('password.edit') }}" style="color: #007bff; text-decoration: none; font-size: 14px; font-weight: bold;">
                🔐 Փոխել գաղտնաբառը
            </a>
        </div>
    </div>
</main>

<style>
    input:focus {border-color: #007bff !important;box-shadow: 0 0 8px rgba(0,123,255,0.1);}
    button:hover {background: #0056b3 !important;}
    a:hover {text-decoration: underline !important;}
</style>
