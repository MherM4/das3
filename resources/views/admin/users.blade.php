<x-app-layout>
    <x-slot:title>{{ __('messages.user_managment') }}</x-slot:title>
@vite(['resources/css/admin-users.css'])

<main class="admin-container">
    <div class="admin-header">
        <h1>{{ __('messages.user_managment') }}</h1>
        <div class="search-box">
           <form action="{{ route('admin.users') }}" method="GET" class="search-box">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.quick_search') }}">
    <button type="submit" class="btn-search">{{ __('messages.search') }}</button>
</form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div style="overflow-x: auto;">
        <table class="user-table">
            <thead>
    <tr>
        <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">ID</a></th>
        <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">{{ __('messages.name') }}</a></th>
        <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">{{ __('messages.email') }}</a></th>
        <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'role', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">{{ __('messages.role') }}</a></th>
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
</x-app-layout>
