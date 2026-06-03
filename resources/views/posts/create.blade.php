<x-app-layout>
    <x-slot:title>{{ __('messages.creat_new_post') }}</x-slot:title>
    @vite(['resources/css/post-create.css', 'resources/js/post-create.js'])

    <main style="max-width: 700px; margin: 40px auto; padding: 30px; background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">

        <h2 style="text-align: center; color: #333; margin-bottom: 30px; font-weight: 700;">{{ __('messages.creat_new_post') }}</h2>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" id="post-form">
            @csrf
            
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px;">{{ __('messages.title') }}</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="{{ __('messages.enter_title') }}"
                       style="width: 100%; padding: 14px; border: 2px solid {{ $errors->has('title') ? 'red' : '#f0f0f0' }}; border-radius: 12px; outline: none; box-sizing: border-box;">
                @error('title') <div style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px;">{{ __('messages.pictures') }}</label>
                <label for="image-input" style="display: block; padding: 20px; background: #f8f9fb; border: 2px dashed {{ $errors->has('images') || $errors->has('images.*') ? 'red' : '#cbd5e0' }}; border-radius: 12px; cursor: pointer; text-align: center;">
                    <span style="font-size: 30px; display: block;">📷</span>
                    <span>{{ __('messages.enter_for_add_pic') }}</span>
                </label>
                <input type="file" id="image-input" name="images[]" multiple accept="image/*" style="display: none;">
                @error('images') <div style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</div> @enderror
                @error('images.*') <div style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</div> @enderror
                <div id="preview-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 12px; margin-top: 15px;"></div>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px;">{{ __('messages.description') }}</label>
                <textarea name="body" rows="6" placeholder="{{ __('messages.enter_descrip') }}"
                          style="width: 100%; padding: 14px; border: 2px solid {{ $errors->has('body') ? 'red' : '#f0f0f0' }}; border-radius: 12px; resize: vertical; box-sizing: border-box;">{{ old('body') }}</textarea>
                @error('body') <div style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px;">{{ __('messages.select_tags') }}</label>
                <select name="tags[]" multiple style="width: 100%; padding: 10px; border: 2px solid #f0f0f0; border-radius: 12px;">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px;">{{ __('messages.categories') }}</label>
                <select name="category_id" style="width: 100%; padding: 14px; border: 2px solid {{ $errors->has('category_id') ? 'red' : '#f0f0f0' }}; border-radius: 12px;">
                    <option value="" disabled selected>{{ __('messages.select_category') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <div style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</div> @enderror
            </div>

            <button type="submit" style="width: 100%; background: #007bff; color: white; border: none; padding: 16px; border-radius: 12px; font-weight: bold; cursor: pointer;">
                {{ __('messages.publ_post') }}
            </button>
        </form>
    </main>
</x-app-layout>
