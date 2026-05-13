<x-app-layout>
    <x-slot:title>Կառավարման վահանակ</x-slot:title>

<main class="admin-container">
    <div class="admin-header">
        <h1>{{ __('messages.user_managment') }}</h1>
        <div class="search-box">
            <input type="text" id="searchInput" oninput="liveSearch()" placeholder="{{ __('messages.quick_search') }}">
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div style="overflow-x: auto;">
        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.email') }}</th>
                    <th>{{ __('messages.role') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th style="text-align: center;">{{ __('messages.action') }}</th>
                </tr>
            </thead>
            <tbody id="userTable">
                @foreach($users as $user)
                    <tr class="user-row">
                        <td>#{{ $user->id }}</td>
                        <td class="search-name">
                            <a href="{{ route('user.profile', $user->id) }}">{{ $user->name }}</a>
                        </td>
                        <td class="search-email">{{ $user->email }}</td>

                        <td>
                            @can('changeRole', $user)
                                <form action="{{ route('admin.users.role', $user->id) }}" method="POST">
                                    @csrf
                                    <select name="role" onchange="this.form.submit()" class="role-select">
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>{{ __('messages.user') }}</option>
                                        <option value="moderator" {{ $user->role == 'moderator' ? 'selected' : '' }}>{{ __('messages.moderator') }}</option>
                                        @if(auth()->user()->role === 'super_admin')
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>{{ __('messages.admin') }}</option>
                                        @endif
                                    </select>
                                </form>
                            @else
                                <span class="badge badge-role">{{ $user->role }}</span>
                            @endcan
                        </td>

                        <td>
                            <span class="badge {{ $user->is_blocked ? 'badge-danger' : 'badge-success' }}">
                                {{ $user->is_blocked ? __('messages.blocked') : __('messages.active') }}
                            </span>
                        </td>

                        <td style="text-align: center;">
                            <div class="action-buttons">
                                @can('manage', $user)
                                    @can('before', auth()->user())
                                        <a href="{{ route('admin.users.edit', $user->id) }}" title="{{ __('messages.edit') }}">✏️</a>
                                    @endcan

                                    <form action="{{ route('admin.users.block', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn {{ $user->is_blocked ? 'btn-unblock' : 'btn-block' }}">
                                           {{ $user->is_blocked ? __('messages.blocked') : __('messages.active') }}
                                        </button>
                                    </form>
                                @else
                                    <span class="lock-icon">🔒</span>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div id="noResults" class="no-results" style="display: none;">
            {{ __('messages.nothing_w_found') }}
        </div>
    </div>
</main>

<style>
    .admin-container { max-width: 1100px; margin: 30px auto; padding: 25px; background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); font-family: sans-serif; }
    .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #f4f4f4; padding-bottom: 15px; }
    .search-box input { padding: 10px 15px; border: 1px solid #ddd; border-radius: 8px; width: 300px; outline: none; transition: 0.3s; }
    .search-box input:focus { border-color: #007bff; box-shadow: 0 0 8px rgba(0,123,255,0.1); }

    .user-table { width: 100%; border-collapse: collapse; }
    .user-table th { background: #f8f9fa; padding: 15px; color: #555; text-align: left; }
    .user-row { border-bottom: 1px solid #eee; }
    .user-row td { padding: 15px; }

    .badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
    .badge-success { background: #d4edda; color: #155724; }
    .badge-danger { background: #f8d7da; color: #721c24; }
    .badge-role { background: #e2e3e5; color: #333; }

    .btn { padding: 8px 14px; cursor: pointer; border: none; border-radius: 6px; font-size: 12px; font-weight: bold; color: white; }
    .btn-block { background: #dc3545; }
    .btn-unblock { background: #28a745; }
    .action-buttons { display: flex; align-items: center; justify-content: center; gap: 15px; }
    .lock-icon { color: #ccc; font-size: 12px; font-style: italic; }
</style>
</x-app-layout>
