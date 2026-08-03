// Rasm preview
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const fileName = document.getElementById('fileName');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'inline-block';
            fileName.textContent = input.files[0].name;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Rasmni olib tashlash
function removeImage() {
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('photo').value = '';
    document.getElementById('fileName').textContent = 'Fayl tanlanmagan';
}

// Tags dropdown
function toggleTagsDropdown() {
    const dropdown = document.getElementById('tagsDropdown');
    dropdown.classList.toggle('show');
    if (dropdown.classList.contains('show')) {
        document.getElementById('tagSearch').focus();
    }
}

// Tags filter
function filterTags(value) {
    const options = document.querySelectorAll('#tagOptions .tag-option');
    const search = value.toLowerCase().trim();
    
    options.forEach(option => {
        const label = option.querySelector('label').textContent.toLowerCase();
        if (label.includes(search)) {
            option.style.display = 'flex';
        } else {
            option.style.display = 'none';
        }
    });
}

// Update selected tags
function updateSelectedTags() {
    const checkboxes = document.querySelectorAll('#tagOptions input[type="checkbox"]:checked');
    const selectedContainer = document.getElementById('selectedTags');
    const hiddenInput = document.getElementById('selectedTagsInput');
    
    const selectedIds = [];
    selectedContainer.innerHTML = '';
    
    checkboxes.forEach(checkbox => {
        const id = checkbox.value;
        const name = checkbox.dataset.name;
        selectedIds.push(id);
        
        const tag = document.createElement('span');
        tag.className = 'selected-tag';
        tag.innerHTML = `
            ${name}
            <span class="remove-tag" onclick="removeTag('${id}')">×</span>
        `;
        selectedContainer.appendChild(tag);
    });
    
    hiddenInput.value = selectedIds.join(',');
}

// Remove single tag
function removeTag(id) {
    const checkbox = document.querySelector(`#tagOptions input[value="${id}"]`);
    if (checkbox) {
        checkbox.checked = false;
        updateSelectedTags();
    }
}

// Close dropdown on outside click
document.addEventListener('click', function(e) {
    const container = document.querySelector('.tags-select-container');
    const dropdown = document.getElementById('tagsDropdown');
    
    if (container && !container.contains(e.target)) {
        dropdown.classList.remove('show');
    }
});

// Prevent dropdown close on search click
document.getElementById('tagSearch')?.addEventListener('click', function(e) {
    e.stopPropagation();
});

// DOM Ready - oldingi qiymatlarni ko'rsatish
document.addEventListener('DOMContentLoaded', function() {
    // Taglarni ko'rsatish
    updateSelectedTags();
}); 







// Post show uchun  
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
    if (textarea) {
        textarea.value = '@' + userName + ' ';
        textarea.focus();
    }
}

// Open delete dialog
function openDeleteDialog(postId, postTitle) {
    const dialog = document.getElementById('deleteDialog');
    const form = document.getElementById('deletePostForm');
    const titleSpan = document.getElementById('deletePostTitle');
    
    if (form) form.action = '/posts/' + postId + '/delete/';
    if (titleSpan) titleSpan.textContent = postTitle;
    
    const checkbox = document.getElementById('deleteCheckbox');
    const button = document.getElementById('confirmDeleteBtn');
    if (checkbox) checkbox.checked = false;
    if (button) button.disabled = true;
    
    if (dialog) dialog.showModal();
}

// Close dialog
function closeDialog(dialogId) {
    const dialog = document.getElementById(dialogId);
    if (dialog) dialog.close();
}

// Toggle delete button
function toggleDeleteButton() {
    const checkbox = document.getElementById('deleteCheckbox');
    const button = document.getElementById('confirmDeleteBtn');
    if (checkbox && button) {
        button.disabled = !checkbox.checked;
    }
} 


