window.moveCarousel = function(postId, direction) {
    const container = document.querySelector(`#carousel-${postId} .carousel-container`);
    if(container) container.scrollBy({ left: direction * container.offsetWidth, behavior: 'smooth' });
};

window.toggleComments = function(postId) {
    const section = document.getElementById(`comment-section-${postId}`);
    if(section) {
        section.style.display = (section.style.display === 'none') ? 'block' : 'none';
    }
};
