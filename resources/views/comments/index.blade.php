<!-- resources/views/comments/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-200">
    <div class="container mx-auto mt-8">
        <div class="bg-white rounded-md shadow-md p-4 mb-4">
            <h2 class="text-lg font-semibold mb-2">{{ $post->title }}</h2>
            <p class="text-sm text-gray-700">{{ $post->content }}</p>
        </div>

        <div class="bg-white rounded-md shadow-md p-4 mb-4">
            <h3 class="text-lg font-semibold mb-2">Comments</h3>
            <div id="comments-container">
                @foreach ($post->comments as $comment)
                    <div class="comment-item bg-white rounded-lg border border-gray-200 mb-2 p-3">
                        <div class="flex items-center space-x-2 text-sm text-gray-500 mb-1">
                            <span class="username font-medium">{{ $comment->user->username }}</span>
                            <span class="dot">•</span>
                            <span class="timestamp">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="comment-text text-gray-800 mb-2">{{ $comment->content }}</div>
                    </div>
                @endforeach
            </div>
            <form id="comment-form" class="mt-4">
                @csrf
                <input type="hidden" id="post-id" value="{{ $post->id }}">
                <div class="mb-4">
                    <textarea id="comment" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                              placeholder="What are your thoughts?" required></textarea>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Comment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const commentForm = document.getElementById('comment-form');

            commentForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const postId = document.getElementById('post-id').value;
                const comment = document.getElementById('comment').value;

                fetch(`/posts/${postId}/comments`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ comment })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'Comment added successfully.') {
                        alert('Comment added successfully.');
                        location.reload();
                    } else {
                        alert('Failed to add comment.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred.');
                });
            });
        });
    </script>
</body>
</html>
