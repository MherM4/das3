@include('components.header')

<main style="max-width: 700px; margin: 40px auto; padding: 30px; background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); font-family: 'Segoe UI', sans-serif;">

    <h2 style="text-align: center; color: #333; margin-bottom: 30px; font-weight: 700;">Խմբագրել գրառումը</h2>

    @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px;">Վերնագիր</label>
            <input type="text" name="title" value="{{ $post->title }}" required
                   style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 16px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px;">Առկա նկարներ</label>
            <div style="display: flex; gap: 10px; flex-wrap: wrap; background: #f9f9f9; padding: 10px; border-radius: 10px;">
                @foreach($post->images as $img)
                    <div style="position: relative;">
                        <img src="{{ asset($img->image) }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                    </div>
                @endforeach
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px;">Ավելացնել նոր նկարներ</label>
            <input type="file" name="images[]" multiple accept="image/*"
                   style="width: 100%; padding: 10px; border: 1px dashed #ccc; border-radius: 10px; cursor: pointer;">
        </div>

        <div style="margin-bottom: 25px;">
            <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px;">Բովանդակություն</label>
            <textarea name="body" rows="6" required
                      style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 16px; resize: vertical; box-sizing: border-box;">{{ $post->body }}</textarea>
        </div>

        <div style="display: flex; gap: 15px;">
            <button type="submit" style="flex: 2; background: #28a745; color: white; border: none; padding: 15px; border-radius: 12px; font-size: 18px; font-weight: bold; cursor: pointer; transition: 0.3s;"
                    onmouseover="this.style.background='#218838'" onmouseout="this.style.background='#28a745'">
                Պահպանել
            </button>

            <a href="{{ route('posts.manage') }}"
               style="flex: 1; text-align: center; text-decoration: none; background: #6c757d; color: white; padding: 15px; border-radius: 12px; font-size: 18px; font-weight: bold; cursor: pointer; transition: 0.3s;"
               onmouseover="this.style.background='#5a6268'" onmouseout="this.style.background='#6c757d'">
                Չեղարկել
            </a>
        </div>
    </form>
</main>
