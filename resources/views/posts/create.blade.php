@include('components.header')

<main style="max-width: 700px; margin: 40px auto; padding: 30px; background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); font-family: 'Segoe UI', sans-serif;">

    <h2 style="text-align: center; color: #333; margin-bottom: 30px; font-weight: 700;">Ստեղծել նոր գրառում</h2>
    @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" id="post-form">
        @csrf

        <div style="margin-bottom: 25px;">
            <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px;">Վերնագիր</label>
            <input type="text" name="title" required placeholder="Մուտքագրեք վերնագիրը..."
                   style="width: 100%; padding: 14px; border: 2px solid #f0f0f0; border-radius: 12px; font-size: 16px; outline: none; transition: 0.3s; box-sizing: border-box;"
                   onfocus="this.style.border='2px solid #007bff'; this.style.background='#fff';"
                   onblur="this.style.background='#fcfcfc'">
        </div>

        <div style="margin-bottom: 25px;">
            <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px;">Նկարներ</label>

            <div style="position: relative;">
                <label for="image-input" style="display: block; padding: 20px; background: #f8f9fb; border: 2px dashed #cbd5e0; border-radius: 12px; cursor: pointer; text-align: center; color: #718096; transition: 0.3s;"
                       onmouseover="this.style.borderColor='#007bff'; this.style.color='#007bff'"
                       onmouseout="this.style.borderColor='#cbd5e0'; this.style.color='#718096'">
                    <span style="font-size: 30px; display: block;">📷</span>
                    <span style="font-weight: 500;">Սեղմեք նկարներ ավելացնելու համար</span>
                    <br><small style="font-size: 12px; color: #a0aec0;">(Կարող եք ընտրել մի քանի ֆայլ)</small>
                </label>
                <input type="file" id="image-input" name="images[]" multiple accept="image/*" style="display: none;">
            </div>

            <div id="preview-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 12px; margin-top: 15px;"></div>
        </div>

        <div style="margin-bottom: 30px;">
            <label style="display: block; font-weight: 600; color: #444; margin-bottom: 8px;">Նկարագրություն</label>
            <textarea name="body" rows="6" required placeholder="Գրեք բովանդակությունը այստեղ..."
                      style="width: 100%; padding: 14px; border: 2px solid #f0f0f0; border-radius: 12px; font-size: 16px; outline: none; transition: 0.3s; resize: vertical; box-sizing: border-box;"
                      onfocus="this.style.border='2px solid #007bff'"></textarea>
        </div>

        <button type="submit" style="width: 100%; background: #007bff; color: white; border: none; padding: 16px; border-radius: 12px; font-size: 18px; font-weight: bold; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 12px rgba(0,123,255,0.3);">
            Հրապարակել գրառումը
        </button>
    </form>
</main>

<script>
    const imageInput = document.getElementById('image-input');
    const previewContainer = document.getElementById('preview-container');

    let dataTransfer = new DataTransfer();

    imageInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);

        files.forEach((file, index) => {
            dataTransfer.items.add(file);

            const reader = new FileReader();
            reader.onload = function(event) {
                const wrapper = document.createElement('div');
                wrapper.className = 'preview-item';
                wrapper.style.position = 'relative';
                wrapper.style.width = '100%';
                wrapper.style.paddingTop = '100%';
                wrapper.style.borderRadius = '10px';
                wrapper.style.overflow = 'hidden';
                wrapper.style.border = '1px solid #ddd';

                wrapper.innerHTML = `
                    <img src="${event.target.result}" style="position: absolute; top:0; left:0; width: 100%; height: 100%; object-fit: cover;">
                    <div onclick="removeImage(this, ${dataTransfer.items.length - 1})"
                         style="position: absolute; top: 5px; right: 5px; background: rgba(255, 77, 77, 0.9); color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; cursor: pointer; font-weight: bold; border: 2px solid white; z-index: 10;">
                        &times;
                    </div>
                `;
                previewContainer.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });

        imageInput.files = dataTransfer.files;
    });

    function removeImage(button, fileIndex) {
        button.parentElement.remove();

        const newDataTransfer = new DataTransfer();
        const { files } = dataTransfer;

        for (let i = 0; i < files.length; i++) {
            if (i !== fileIndex) {
                newDataTransfer.items.add(files[i]);
            }
        }

        dataTransfer = newDataTransfer;
        imageInput.files = dataTransfer.files;
    }
</script>

<style>
    button:hover {background: #0056b3 !important;transform: translateY(-1px);}
    button:active {transform: translateY(0);}
</style>
