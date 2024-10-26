document.addEventListener('DOMContentLoaded', function () {
    const commentButtons = document.querySelectorAll('.comment-btn');
    const modal = document.getElementById('comment-modal');
    const closeModal = document.getElementById('close-modal');
    const postIdInput = document.getElementById('post-id');
    const commentForm = document.getElementById('comment-form');

    commentButtons.forEach(button => {
        button.addEventListener('click', function () {
            postIdInput.value = this.dataset.postId;
            modal.classList.remove('hidden');
        });
    });

    closeModal.addEventListener('click', function () {
        modal.classList.add('hidden');
    });

    commentForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const postId = postIdInput.value;
        const comment = document.getElementById('comment').value;

        fetch(`/posts/${postId}/comments`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ comment })
        })
            .then(response => response.text()) // Change to response.text() to log the raw response
            .then(text => {
                console.log(text); // Log the raw response text
                try {
                    const data = JSON.parse(text); // Parse the response text as JSON
                    if (data.message === 'Comment added successfully.') {
                        alert('Comment added successfully.');
                        modal.classList.add('hidden');
                    } else {
                        alert('Failed to add comment.');
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    alert('An error occurred while processing the response.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred.');
            });
    });
});
