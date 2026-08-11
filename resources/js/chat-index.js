window.editChat = function(chatId) {
    document.getElementById('link-' + chatId).style.display = 'none';
    let input = document.getElementById('input-' + chatId);
    input.style.display = 'inline-block';
    input.focus();
};

window.saveChatName = function(input) {
    let chatId = input.getAttribute('data-id');
    let newName = input.value;
    if (newName.trim() !== "") {
        let form = document.getElementById('renameForm');
        form.action = `/chat/${chatId}/rename`;
        document.getElementById('newName').value = newName;
        form.submit();
    } else {
        input.style.display = 'none';
        document.getElementById('link-' + chatId).style.display = 'inline';
    }
};

window.deleteChatName = function(chatId, defaultName) {
    const csrfToken = document.querySelector('input[name="_token"]').value;

    fetch(`/chat/${chatId}/remove-name`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json'
        }
    }).then(response => {
        if (response.ok) {
            document.getElementById('link-' + chatId).innerText = defaultName;
            document.getElementById('input-' + chatId).value = '';
            document.getElementById('delete-name-' + chatId).style.display = 'none';
        }
    });
};
