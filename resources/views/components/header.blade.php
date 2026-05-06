<header style="display: flex; justify-content: space-between; align-items: center; padding: 10px 50px; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); font-family: sans-serif; position: sticky; top: 0; z-index: 1000;">

    <div style="display: flex; align-items: center; gap: 30px;">
        <nav>
            <a href="{{ route('home') }}" style="text-decoration: none; color: #333; font-weight: bold; font-size: 18px; display: flex; align-items: center; gap: 5px;">
                Գլխավոր
            </a>
        </nav>
    </div>



    <nav style="display: flex; align-items: center; gap: 25px;">
        <div class="user-dropdown" style="position: relative; display: inline-block;">
            <button onclick="toggleMenu()" style="background: none; border: none; display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 5px 10px; border-radius: 8px; transition: 0.3s;" onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='none'">
                <img src="{{ auth()->user()->avatar_url }}" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd;">

                <strong style="font-size: 15px; color: #333;">{{ auth()->user()->name }}</strong>
                <span style="font-size: 10px; color: #777;">▼</span>
            </button>

            <div id="dropdownMenu" style="display: none; position: absolute; right: 0; top: 45px; background: white; min-width: 200px; box-shadow: 0 8px 24px rgba(0,0,0,0.15); border-radius: 10px; border: 1px solid #eee; overflow: hidden; animation: fadeIn 0.2s ease;">

                <a href="{{ route('profile') }}" class="dropdown-item">Իմ Պրոֆիլը</a>
                <a href="{{ route('posts.manage') }}" class="dropdown-item">Իմ Գրառումները</a>

                <a href="{{ route('posts.saved') }}" class="dropdown-item">Պահպանվածներ</a>

                <a href="{{ route('posts.trash') }}" class="dropdown-item" style="color: #6c757d;">Իմ Աղբամանը</a>

                <hr style="border: 0; border-top: 1px solid #eee; margin: 5px 0;">

                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin')
                    <div style="padding: 5px 15px; font-size: 11px; color: #999; font-weight: bold; text-transform: uppercase;">Admin Control</div>
                    <a href="{{ route('admin.users') }}" class="dropdown-item">Օգտատերեր</a>
                    <a href="{{ route('admin.trash') }}" class="dropdown-item" style="color: #dc3545;">⚠Admin Աղբաման</a>
                    <hr style="border: 0; border-top: 1px solid #eee; margin: 5px 0;">
                @endif

                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="dropdown-item" style="width: 100%; text-align: left; border: none; background: none; color: #ff4d4d; cursor: pointer; font-weight: bold;">
                        Ելք
                    </button>
                </form>
            </div>
        </div>
    </nav>

</header>
<x-Subheader />
<style>
    .dropdown-item {
        display: block;
        padding: 12px 15px;
        text-decoration: none;
        color: #333;
        font-size: 14px;
        transition: 0.2s;
    }
    .dropdown-item:hover {
        background-color: #f8f9fa;
        padding-left: 20px;
        color: #007bff;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    function toggleMenu() {
        const menu = document.getElementById('dropdownMenu');
        if (menu.style.display === 'none' || menu.style.display === '') {
            menu.style.display = 'block';
        } else {
            menu.style.display = 'none';
        }
    }

    window.onclick = function(event) {
        if (!event.target.closest('.user-dropdown')) {
            document.getElementById('dropdownMenu').style.display = 'none';
        }
    }
</script>
