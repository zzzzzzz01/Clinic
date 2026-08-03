
// LIKE bosilganda
function handleLike(postId, element) { 

const likeBtn = element;
const likeCountSpan = likeBtn.querySelector('.like-count');
const dislikeBtn = document.querySelector('.dislike-btn');
const dislikeCountSpan = dislikeBtn ? dislikeBtn.querySelector('.dislike-count') : null;

if (!likeCountSpan) {
    console.error('Like count span topilmadi');
    return;
}

const isLiked = likeBtn.classList.contains('liked');
const isDisliked = dislikeBtn ? dislikeBtn.classList.contains('disliked') : false;

let currentLikeCount = parseInt(likeCountSpan.textContent) || 0;
let currentDislikeCount = dislikeCountSpan ? parseInt(dislikeCountSpan.textContent) || 0 : 0;

// Optimistik UI update
if (isLiked) {
    // Like bor -> like ni o'chiramiz
    likeBtn.classList.remove('liked');
    likeCountSpan.textContent = currentLikeCount - 1;
} else {
    // Like bosamiz
    likeBtn.classList.add('liked');
    likeCountSpan.textContent = currentLikeCount + 1;
    
    // Agar dislike bosilgan bo'lsa, dislike ni o'chiramiz
    if (dislikeBtn && isDisliked) {
        dislikeBtn.classList.remove('disliked');
        if (dislikeCountSpan) {
            dislikeCountSpan.textContent = currentDislikeCount - 1;
        }
    }
}

const token = document.querySelector('meta[name="csrf-token"]');
if (!token) {
    console.error('CSRF token topilmadi');
    return;
}

fetch('/posts/' + postId + '/like', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token.getAttribute('content'),
        'Accept': 'application/json'
    }
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        document.querySelector('.like-btn .like-count').textContent = data.liked_count;
        document.querySelector('.dislike-btn .dislike-count').textContent = data.unliked_count;
    } else {
        location.reload();
    }
})
.catch(error => {
    console.error('Error:', error);
    location.reload();
});
}

// DISLIKE bosilganda
function handleDislike(postId, element) { 

const dislikeBtn = element;
const dislikeCountSpan = dislikeBtn.querySelector('.dislike-count');
const likeBtn = document.querySelector('.like-btn');
const likeCountSpan = likeBtn ? likeBtn.querySelector('.like-count') : null;

if (!dislikeCountSpan) {
    console.error('Dislike count span topilmadi');
    return;
}

const isDisliked = dislikeBtn.classList.contains('disliked');
const isLiked = likeBtn ? likeBtn.classList.contains('liked') : false;

let currentDislikeCount = parseInt(dislikeCountSpan.textContent) || 0;
let currentLikeCount = likeCountSpan ? parseInt(likeCountSpan.textContent) || 0 : 0;

// Optimistik UI update
if (isDisliked) {
    // Dislike bor -> dislike ni o'chiramiz
    dislikeBtn.classList.remove('disliked');
    dislikeCountSpan.textContent = currentDislikeCount - 1;
} else {
    // Dislike bosamiz
    dislikeBtn.classList.add('disliked');
    dislikeCountSpan.textContent = currentDislikeCount + 1;
    
    // Agar like bosilgan bo'lsa, like ni o'chiramiz
    if (likeBtn && isLiked) {
        likeBtn.classList.remove('liked');
        if (likeCountSpan) {
            likeCountSpan.textContent = currentLikeCount - 1;
        }
    }
}

const token = document.querySelector('meta[name="csrf-token"]');
if (!token) {
    console.error('CSRF token topilmadi');
    return;
}

fetch('/posts/' + postId + '/dislike', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token.getAttribute('content'),
        'Accept': 'application/json'
    }
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        document.querySelector('.like-btn .like-count').textContent = data.liked_count;
        document.querySelector('.dislike-btn .dislike-count').textContent = data.unliked_count;
    } else {
        location.reload();
    }
})
.catch(error => {
    console.error('Error:', error);
    location.reload();
});
}

// Reply to comment
function replyComment(button) {
    const commentBody = button.closest('.comment-body');
    const userName = commentBody.querySelector('.comment-user').textContent.trim();
    const textarea = document.querySelector('.comment-form textarea');
    textarea.value = '@' + userName + ' ';
    textarea.focus();
} 