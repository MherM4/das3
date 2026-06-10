<x-app-layout>
    <x-slot:title>{{ __('messages.edit_post') }}</x-slot:title>

    <main style="max-width: 700px; margin: 40px auto; padding: 30px; background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); font-family: 'Segoe UI', sans-serif;">
        <h2 style="text-align: center; color: #333; margin-bottom: 30px; font-weight: 700;">{{ __('messages.edit_post') }}</h2>

        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px;">{{ __('messages.title') }}</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}"
                       style="width: 100%; padding: 12px; border: 2px solid {{ $errors->has('title') ? '#dc3545' : '#eee' }}; border-radius: 10px; box-sizing: border-box;">
                @error('title') <div style="color: #dc3545; font-size: 14px; margin-top: 5px;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px;">{{ __('messages.select_category') }}</label>
                <select name="category_id" style="width: 100%; padding: 12px; border: 2px solid {{ $errors->has('category_id') ? '#dc3545' : '#eee' }}; border-radius: 10px; box-sizing: border-box;">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name['hy'] ?? $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <div style="color: #dc3545; font-size: 14px; margin-top: 5px;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px;">{{ __('messages.select_tags') }}</label>
                <div style="display: flex; gap: 15px; flex-wrap: wrap; background: #f9f9f9; padding: 12px; border-radius: 10px; border: 1px solid {{ $errors->has('tags') ? '#dc3545' : '#eee' }};">
                    @foreach($tags as $tag)
                        <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                {{ (is_array(old('tags')) ? in_array($tag->id, old('tags')) : $post->tags->contains($tag->id)) ? 'checked' : '' }}>
                            {{ $tag->name }}
                        </label>
                    @endforeach
                </div>
                @error('tags') <div style="color: #dc3545; font-size: 14px; margin-top: 5px;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px;">{{ __('messages.add_new_img') }}</label>
                <input type="file" name="images[]" multiple accept="image/*" style="width: 100%; padding: 10px; border: 1px dashed {{ $errors->has('images') ? '#dc3545' : '#ccc' }}; border-radius: 10px;">
                @error('images') <div style="color: #dc3545; font-size: 14px; margin-top: 5px;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px;">{{ __('messages.content') }}</label>
                <textarea name="body" rows="6" style="width: 100%; padding: 12px; border: 2px solid {{ $errors->has('body') ? '#dc3545' : '#eee' }}; border-radius: 10px; box-sizing: border-box;">{{ old('body', $post->body) }}</textarea>
                @error('body') <div style="color: #dc3545; font-size: 14px; margin-top: 5px;">{{ $message }}</div> @enderror
            </div>

            <button type="submit" style="width: 100%; background: #28a745; color: white; border: none; padding: 15px; border-radius: 12px; font-size: 18px; font-weight: bold; cursor: pointer;">
                {{ __('messages.save') }}
            </button>
        </form>
    </main>
</x-app-layout>
