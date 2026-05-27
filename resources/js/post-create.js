const imageInput = document.getElementById('image-input');
const previewContainer = document.getElementById('preview-container');

let dataTransfer = new DataTransfer();

imageInput.addEventListener('change', function(e) {
    const files = Array.from(e.target.files);

    files.forEach((file) => {
        dataTransfer.items.add(file);
        const index = dataTransfer.items.length - 1;

        const reader = new FileReader();
        reader.onload = function(event) {
            const wrapper = document.createElement('div');
            wrapper.className = 'preview-item';
            wrapper.dataset.index = index;

            wrapper.style.cssText = "position: relative; width: 100px; height: 100px; border-radius: 10px; overflow: hidden; border: 1px solid #ddd; display: inline-block; margin: 5px;";

            wrapper.innerHTML = `
                <img src="${event.target.result}" style="width: 100%; height: 100%; object-fit: cover;">
                <div onclick="window.removeImage(this)"
                     style="position: absolute; top: 5px; right: 5px; background: rgba(255, 77, 77, 0.9); color: white; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                    &times;
                </div>
            `;
            previewContainer.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });

    imageInput.files = dataTransfer.files;
});

window.removeImage = function(button) {
    const wrapper = button.parentElement;
    const indexToRemove = parseInt(wrapper.dataset.index);

    wrapper.remove();

    const newDataTransfer = new DataTransfer();
    const files = dataTransfer.files;

    for (let i = 0; i < files.length; i++) {
        if (i !== indexToRemove) {
            newDataTransfer.items.add(files[i]);
        }
    }

    dataTransfer = newDataTransfer;
    imageInput.files = dataTransfer.files;

    const items = document.querySelectorAll('.preview-item');
    items.forEach((item, newIndex) => {
        item.dataset.index = newIndex;
    });
};
