<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SocialConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="{{ asset('js/notification.js') }}" defer></script>
    <script src="{{ asset('js/voting.js') }}" defer></script>
    <script>
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
    </script>
</head>
<body class="bg-gray-200">
<nav class="bg-white border-b border-gray-300">
    <div class="container mx-auto px-4 py-2 flex items-center justify-between">
        <a href="{{ route('home') }}" class="text-red-500 text-3xl font-bold">SocialConnect</a>
        <div class="relative">
            <form action="{{ route('search.user') }}" method="GET">
                <input type="text" name="query" placeholder="Search for a user" class="bg-gray-100 rounded-full py-1 px-4 w-64">
                <button type="submit" class="absolute right-3 top-2 text-gray-400">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <div class="flex items-center">
            @auth
                <span class="mr-4">Welcome, {{ Auth::user()->username }}</span>
                <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : 'default-profile.png' }}"
                     alt="Profile Picture"
                     class="w-16 h-16 rounded-full mr-4">

                <!-- Notification Bell -->
                <div class="relative mr-4">
                    <button id="notification-bell" class="relative">
                        <i class="fas fa-bell text-gray-500 hover:text-gray-700"></i>
                        @if(Auth::user()->unreadNotifications()->count() > 0)
                            <span id="notification-badge"
                                  class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">
                                    {{ Auth::user()->unreadNotifications()->count() }}
                                </span>
                        @endif
                    </button>
                    <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50">
                        <div class="p-2 border-b border-gray-200">
                            <h3 class="text-lg font-semibold">Notifications</h3>
                        </div>
                        <div class="max-h-96 overflow-y-auto">
                            <div id="notification-list" class="divide-y divide-gray-200">
                                @forelse(Auth::user()->notifications()->latest()->take(10)->get() as $notification)
                                    <div class="notification-item p-4 hover:bg-gray-50 {{ $notification->pivot->read_status === 'unread' ? 'bg-blue-50' : '' }}"
                                         data-notification-id="{{ $notification->id }}">
                                        <p class="text-sm text-gray-800">{{ $notification->message }}</p>
                                        <span class="text-xs text-gray-500">{{ $notification->sent_at->diffForHumans()}}</span>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-gray-500">
                                        No notifications
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('user.profile', ['username' => Auth::user()->username]) }}"
                   class="bg-green-500 text-white px-4 py-1 rounded-full hover:bg-green-600 mr-2">Profile</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded-full hover:bg-blue-600">Log Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-1 rounded-full hover:bg-blue-600">Log In</a>
                <a href="{{ route('register') }}" class="bg-gray-300 text-blue-500 px-4 py-1 rounded-full ml-2 hover:bg-gray-400">Sign Up</a>
            @endauth
        </div>
    </div>
</nav>

<main class="container mx-auto mt-8 flex">
    <div class="w-2/3 pr-4">
        @foreach ($posts as $post)
            <div class="bg-white rounded-md shadow-md mb-4 flex" data-post-id="{{ $post->id }}">
                <!-- Post content here -->
                <div class="p-4 flex-grow">
                    <div class="text-xs text-gray-500 mb-1">
                        Posted by {{ $post->user->username }} {{ $post->created_at->diffForHumans() }}
                    </div>
                    <h2 class="text-lg font-semibold mb-2">{{ $post->title }}</h2>
                    <p class="text-sm text-gray-700">{{ $post->content }}</p>
                    <div class="text-sm text-gray-500 mt-2">
                <span class="mr-4">
                    <i class="far fa-comment comment-btn" data-post-id="{{ $post->id }}"></i> {{ $post->comments->count() }} comments
                </span>
                        <span class="mr-4">
                    <i class="fas fa-share"></i> Share
                </span>
                        <span>
                    <i class="far fa-bookmark"></i> Save
                </span>
                    </div>
                    <!-- Comments section -->
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold mb-2">Comments</h3>
                        @foreach ($post->comments as $comment)
                            <div class="comment-item bg-white rounded-lg border border-gray-200 mb-2 p-3">
                                <div class="flex items-center space-x-2 text-sm text-gray-500 mb-1">
                                    <span class="username font-medium">{{ $comment->user->username }}</span>
                                    <span class="dot">•</span>
                                    <span class="timestamp">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="comment-text text-gray-800 mb-2">{{ $comment->comment }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="w-1/3 pl-4">
        <div class="bg-white rounded-md shadow-md p-4 mb-4">
            <h2 class="text-lg font-semibold mb-2">About SocialConnect</h2>
            <p class="text-sm mb-4">Welcome to SocialConnect, a place to share and discuss interesting topics!</p>
            <button onclick="window.location.href='{{ route('posts.create') }}'"
                    class="bg-blue-500 text-white w-full py-1 rounded-full hover:bg-blue-600">
                Create Post
            </button>
        </div>
        <div class="bg-white rounded-md shadow-md p-4">
            <h2 class="text-lg font-semibold mb-2">SocialConnect Rules</h2>
            <ol class="list-decimal list-inside text-sm">
                <li class="mb-2">Be respectful to others</li>
                <li class="mb-2">No spam or self-promotion</li>
                <li class="mb-2">Use appropriate tags</li>
                <li>Follow content policy</li>
            </ol>
        </div>
    </div>
</main>

<!-- Comment Modal -->
<div id="comment-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-1/3">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold">Add a Comment</h3>
            <button id="close-modal" class="text-gray-500 hover:text-gray-700">&times;</button>
        </div>
        <div class="p-4">
            <form id="comment-form">
                @csrf
                <input type="hidden" id="post-id">
                <div class="mb-4">
                    <label for="comment" class="block text-gray-700 text-sm font-bold mb-2">Comment</label>
                    <textarea id="comment" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<footer class="bg-white mt-8 py-4 border-t border-gray-300">
    <div class="container mx-auto text-center text-sm text-gray-500">
        <p>&copy; 2024 SocialConnect. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
