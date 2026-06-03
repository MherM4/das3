window.previewImage = function(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').src = e.target.result;

            document.getElementById('remove-avatar-btn').style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
};

window.removeAvatar = function() {
    const preview = document.getElementById('avatar-preview');
    const input = document.getElementById('avatar');

    preview.src = window.defaultAvatarUrl;

    input.value = '';
    document.getElementById('remove-avatar-btn').style.display = 'none';
};
