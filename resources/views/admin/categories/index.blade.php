<x-app-layout>
    <x-slot:title>{{ __('messages.catg_management') }}</x-slot:title>
    <main style="max-width: 800px; margin: 30px auto; padding: 25px; background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); font-family: sans-serif;">
        <h1 style="color: #333; font-size: 24px; margin-bottom: 20px;">{{ __('messages.category_mng') }}</h1>


    <form action="{{ route('admin.categories.store') }}" method="POST" style="margin-bottom: 30px;">
        @csrf

            <div style="display: flex; gap: 30px; align-items: flex-start;">
                <div style="flex: 1;">
                    <input type="text" name="name_hy" placeholder="{{ __('messages.category_am_name') }}"
                           style="width: 100%; padding: 12px; border: 1px solid {{ $errors->has('name_hy') ? 'red' : '#ddd' }}; border-radius: 8px; outline: none;">
                    @error('name_hy')
                        <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="flex: 1;">
                    <input type="text" name="name_en" placeholder="{{ __('messages.category_en_name') }}"
                           style="width: 100%; padding: 12px; border: 1px solid {{ $errors->has('name_en') ? 'red' : '#ddd' }}; border-radius: 8px; outline: none;">
                    @error('name_en')
                        <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" style="background: #28a745; color: white; border: none; padding: 12px 20px; border-radius: 8px; cursor: pointer; font-weight: bold;">
                    {{ __('messages.add') }}
                </button>
            </div>
    </form>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid #f4f4f4;">
                    <th style="padding: 12px;">{{ __('messages.naming') }}</th>
                    <th style="padding: 12px; text-align: right;">{{ __('messages.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 12px; font-size: 16px;">
                                @if(is_array($category->name))
                                    {{ $category->name[app()->getLocale()] ?? array_values($category->name)[0] }}
                                @else
                                    @php $decoded = json_decode($category->name, true); @endphp
                                    {{ $decoded[app()->getLocale()] ?? ($decoded['hy'] ?? $category->name) }}
                                @endif
                        </td>
                        <td style="padding: 12px; text-align: right;">
                            @can('delete', $category)
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('{{ __('messages.are_u_sure') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; font-size: 14px;">
                                        🗑 {{ __('messages.delete') }}
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</x-app-layout>
