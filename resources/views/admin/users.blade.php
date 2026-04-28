@include('components.header')

<main style="max-width: 1100px; margin: 30px auto; padding: 25px; background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); font-family: sans-serif;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #f4f4f4; padding-bottom: 15px;">
        <h1 style="margin: 0; color: #333; font-size: 24px;">Օգտատերերի կառավարում</h1>

        <div style="position: relative;">
            <input type="text" id="searchInput" oninput="liveSearch()"
                   placeholder="Արագ որոնում..."
                   style="padding: 10px 15px; border: 1px solid #ddd; border-radius: 8px; width: 300px; outline: none; transition: border 0.3s; font-size: 15px;">
        </div>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
            <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                <th style="padding: 15px; color: #555;">ID</th>
                <th style="padding: 15px; color: #555;">Անուն</th>
                <th style="padding: 15px; color: #555;">Email</th>
                <th style="padding: 15px; color: #555;">Դեր</th>
                <th style="padding: 15px; color: #555;">Կարգավիճակ</th>
                <th style="padding: 15px; color: #555; text-align: center;">Գործողություն</th>
            </tr>
            </thead>
            <tbody id="userTable">
            @foreach($users as $user)
                <tr class="user-row" style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px; color: #777;">#{{ $user->id }}</td>

                    <td class="search-name" style="padding: 15px; font-weight: 500;">
                        <a href="{{ route('user.profile', $user->id) }}" style="text-decoration: none; color: #007bff; font-weight: bold; border-bottom: 1px dashed #007bff;">
                            {{ $user->name }}
                        </a>
                    </td>

                    <td class="search-email" style="padding: 15px; color: #555;">{{ $user->email }}</td>

                    <td style="padding: 15px;">
                        @if(auth()->user()->role === 'super_admin')
                            @if($user->role === 'super_admin')
                                <span style="padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; background: #cce5ff; color: #004085; text-transform: uppercase;">
                                    SUPER ADMIN
                                </span>
                            @else
                                <form action="{{ route('admin.users.role', $user->id) }}" method="POST">
                                    @csrf
                                    <select name="role" onchange="this.form.submit()" style="padding: 5px; border-radius: 5px; border: 1px solid #ddd; background: #fff; cursor: pointer;">
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </form>
                            @endif
                        @else
                            <span style="padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; background: #e2e3e5; text-transform: capitalize;">
                                {{ $user->role }}
                            </span>
                        @endif
                    </td>

                    <td style="padding: 15px;">
                        <span style="padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; background: {{ $user->is_blocked ? '#f8d7da' : '#d4edda' }}; color: {{ $user->is_blocked ? '#721c24' : '#155724' }};">
                            {{ $user->is_blocked ? 'Բլոկված' : 'Ակտիվ' }}
                        </span>
                    </td>

                    <td style="padding: 15px; text-align: center;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 15px;">
                            @if($user->role !== 'super_admin')
                                @if(auth()->user()->role === 'super_admin')
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                       style="text-decoration: none; font-size: 18px;" title="Խմբագրել">
                                        ✏️
                                    </a>
                                @endif
                                <form action="{{ route('admin.users.block', $user->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" style="padding: 8px 14px; cursor: pointer; background: {{ $user->is_blocked ? '#28a745' : '#dc3545' }}; color: white; border: none; border-radius: 6px; font-size: 12px; font-weight: bold; transition: 0.3s;">
                                        {{ $user->is_blocked ? 'Ապաբլոկել' : 'Բլոկել' }}
                                    </button>
                                </form>
                            @else
                                <span style="color: #ccc; font-size: 12px; font-style: italic;">Անձեռնմխելի</span>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div id="noResults" style="display: none; padding: 40px; text-align: center; color: #888; background: #fdfdfd; border-radius: 10px; margin-top: 10px;">
            🔍 Ոչինչ չգտնվեց ձեր որոնման հիման վրա:
        </div>
    </div>
</main>

<script>
    function liveSearch() {
        let input = document.getElementById('searchInput').value.toLowerCase();
        let rows = document.querySelectorAll('.user-row');
        let noResults = document.getElementById('noResults');
        let found = false;

        rows.forEach(row => {
            let name = row.querySelector('.search-name').textContent.toLowerCase();
            let email = row.querySelector('.search-email').textContent.toLowerCase();

            if (name.includes(input) || email.includes(input)) {
                row.style.display = "";
                found = true;
            } else {
                row.style.display = "none";
            }
        });

        noResults.style.display = found ? "none" : "block";
    }
</script>

<style>
    #searchInput:focus {border-color: #007bff !important;box-shadow: 0 0 8px rgba(0,123,255,0.1);}
    .search-name a:hover {color: #0056b3 !important;border-bottom-style: solid !important;}
    button:hover {opacity: 0.8;}
</style>
