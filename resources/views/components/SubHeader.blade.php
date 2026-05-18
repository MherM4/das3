@php
$categories = \App\Models\Category::has('posts')->get();
$locale = app()->getLocale();
@endphp

<div style="background: #fff; border-bottom: 1px solid #eee; padding: 15px 0;">
    <div style="max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; padding: 0 20px; gap: 20px;">

        <form action="/" method="GET" style="flex: 1; display: flex;">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="{{ __('messages.search_by') }}"
                   style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; outline: none;">
            <button type="submit" style="margin-left: 5px; background: #007bff; color: white; border: none; padding: 0 15px; border-radius: 8px; cursor: pointer;">
                🔍
            </button>
        </form>

        <form action="/" method="GET" id="sub-cat-form">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <select name="category_id" onchange="this.form.submit()"
                    style="padding: 10px; border-radius: 8px; border: 1px solid #ddd; outline: none; cursor: pointer;">
                <option value="">{{ __('messages.all_categories') }}</option>
                @foreach($categories as $category)
                    @php
                        if (is_array($category->name)) {
                            $catName = $category->name[$locale] ?? array_values($category->name)[0];
                        } else {
                            $decoded = json_decode($category->name, true);
                            $catName = $decoded[$locale] ?? ($decoded['hy'] ?? $category->name);
                        }
                    @endphp

                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $catName }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
</div>
