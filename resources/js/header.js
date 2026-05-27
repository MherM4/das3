
window.toggleMenu = function() {
    const menu = document.getElementById('dropdownMenu');
    if (!menu) return;

    if (menu.style.display === 'none' || menu.style.display === '') {
        menu.style.display = 'block';
    } else {
        menu.style.display = 'none';
    }
};

window.onclick = function(event) {
    const menu = document.getElementById('dropdownMenu');
    const dropdown = document.querySelector('.user-dropdown');

    if (menu && dropdown && !event.target.closest('.user-dropdown')) {
        menu.style.display = 'none';
    }
};

