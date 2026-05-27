window.setupReply = function(postId, commentId, username) {
    const input = document.getElementById('comment-input-' + postId);
    const parentInput = document.getElementById('parent-id-' + postId);
    const cancelBtn = document.getElementById('cancel-reply-' + postId);
    const form = document.getElementById('main-comment-form-' + postId);

    input.placeholder = window.commentTranslations.replyTo + " " + username + "...";
    parentInput.value = commentId;
    form.action = window.commentTranslations.replyRoute + "/" + commentId + "/reply";
    cancelBtn.style.display = 'block';
    input.focus();
    input.scrollIntoView({ behavior: 'smooth', block: 'center' });
};

window.resetCommentInput = function(postId) {
    const input = document.getElementById('comment-input-' + postId);
    const parentInput = document.getElementById('parent-id-' + postId);
    const cancelBtn = document.getElementById('cancel-reply-' + postId);
    const form = document.getElementById('main-comment-form-' + postId);

    input.placeholder = window.commentTranslations.writeComment;
    parentInput.value = "";
    form.action = window.commentTranslations.defaultRoute;
    cancelBtn.style.display = 'none';
    input.value = "";
};

window.toggleRepliesBlock = function(id, button) {
    const block = document.getElementById('replies-block-' + id);
    const count = button.getAttribute('data-count') || 0;

    if (block.style.display === 'none' || block.style.display === '') {
        block.style.display = 'block';
        button.innerText = window.commentTranslations.hideReplies;
    } else {
        block.style.display = 'none';
        button.innerText = '• ' + window.commentTranslations.viewReplies + ' (' + count + ')';
    }
};
