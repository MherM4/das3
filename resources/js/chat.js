window.sendMsg = function() {
    const input = document.getElementById('message-input');
    const content = input.value;
    if (!content.trim()) return;

    fetch('/chat/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ chat_id: window.chatId, content: content })
    })
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('chat-messages');
        const userName = data.user ? data.user.name : '';

        container.insertAdjacentHTML('beforeend', `
            <div id="msg-${data.id}" class="message-row" style="display: flex; flex-direction: column; align-items: flex-end; margin-bottom: 15px; position: relative;">
                <span style="font-size: 11px; color: #777; margin-bottom: 2px;">${userName}</span>
                <div style="display: flex; align-items: center; gap: 5px;">
                    <!-- Նախ նամակի բլոկը -->
                    <div style="background: #007bff; color: white; padding: 10px 15px; border-radius: 18px;">
                        <p id="msg-${data.id}-text" style="margin:0;">${data.content}</p>
                    </div>
                    <!-- Հետո 3 կետիկի կոճակը (աջ կողմում) -->
                    <button onclick="toggleMenu(${data.id}, event)" style="background: none; border: none; cursor: pointer; font-size: 16px;">⋮</button>
                </div>
                <div id="menu-${data.id}" style="display: none; position: absolute; top: 25px; right: 0; background: white; border: 1px solid #ccc; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.15); z-index: 10; padding: 5px;">
                    <button onclick="editMsg(${data.id})" style="display: block; width: 100%; text-align: left; background: none; border: none; padding: 5px 10px; cursor: pointer;">Խմբագրել</button>
                    <button onclick="deleteMsg(${data.id})" style="display: block; width: 100%; text-align: left; background: none; border: none; padding: 5px 10px; color: red; cursor: pointer;">Ջնջել</button>
                </div>
            </div>
        `);

        input.value = '';
        container.scrollTop = container.scrollHeight;
    })
    .catch(err => console.error("Error:", err));
};

window.toggleMenu = function(id, event) {
    if (event) event.stopPropagation();

    document.querySelectorAll('[id^="menu-"]').forEach(menu => {
        if (menu.id !== `menu-${id}`) {
            menu.style.display = 'none';
        }
    });

    const menu = document.getElementById(`menu-${id}`);
    if (menu) {
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    }
};

document.addEventListener('click', function() {
    document.querySelectorAll('[id^="menu-"]').forEach(menu => {
        menu.style.display = 'none';
    });
});

window.deleteMsg = function(msgId) {
    if (!confirm('Համոզվա՞ծ եք։')) return;

    fetch(`/chat/message/${msgId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        if (response.ok) {
            document.getElementById('msg-' + msgId).remove();
        } else {
            alert('Չհաջողվեց ջնջել նամակը');
        }
    })
    .catch(error => console.error('Error:', error));
};

window.editMsg = function(msgId) {
    let textElement = document.getElementById('msg-' + msgId + '-text');
    let oldContent = textElement.innerText;
    let newContent = prompt("Փոխել հաղորդագրությունը", oldContent);

    if (newContent === null || newContent.trim() === "") return;

    fetch(`/chat/message/${msgId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ content: newContent })
    })
    .then(response => {
        if (response.ok) {
            textElement.innerText = newContent;
            const menu = document.getElementById('menu-' + msgId);
            if (menu) menu.style.display = 'none';
        } else {
            alert('Չհաջողվեց պահպանել');
        }
    })
    .catch(error => console.error('Error:', error));
};
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('message-input');
    if (!input) return;

    input.addEventListener('keydown', function(event) {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            window.sendMsg();       
        }
    });
});
