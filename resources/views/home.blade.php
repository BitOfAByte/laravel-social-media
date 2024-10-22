<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redditlike</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200">
<nav class="bg-white border-b border-gray-300">
    <div class="container mx-auto px-4 py-2 flex items-center justify-between">
        <a href="{{ route('home') }}" class="text-red-500 text-3xl font-bold">redditlike</a>
        <div class="relative">
            <input type="text" placeholder="Search Redditlike" class="bg-gray-100 rounded-full py-1 px-4 w-64">
            <i class="fas fa-search absolute right-3 top-2 text-gray-400"></i>
        </div>
        <div>
            @auth
                <span class="mr-4">Welcome, {{ Auth::user()->username }}</span>
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
            <div class="bg-white rounded-md shadow-md mb-4 flex">
                <div class="w-10 bg-gray-100 rounded-l-md flex flex-col items-center py-2">
                    <button class="text-gray-400 hover:text-red-500"><i class="fas fa-arrow-up"></i></button>
                    <span class="text-sm font-bold my-1">{{ $post['upvotes'] }}</span>
                    <button class="text-gray-400 hover:text-blue-500"><i class="fas fa-arrow-down"></i></button>
                </div>
                <div class="p-4 flex-grow">
                    <div class="text-xs text-gray-500 mb-1">
                        Posted by {{ $post['author'] }} in {{ $post['subreddit'] }} {{ $post['time'] }}
                    </div>
                    <h2 class="text-lg font-semibold mb-2">{{ $post['title'] }}</h2>
                    <div class="text-sm text-gray-500">
                        <span class="mr-4"><i class="far fa-comment"></i> {{ $post['comments'] }} comments</span>
                        <span class="mr-4"><i class="fas fa-share"></i> Share</span>
                        <span><i class="far fa-bookmark"></i> Save</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="w-1/3 pl-4">
        <div class="bg-white rounded-md shadow-md p-4 mb-4">
            <h2 class="text-lg font-semibold mb-2">About Community</h2>
            <p class="text-sm mb-4">Welcome to Redditlike, a place to share and discuss interesting topics!</p>
            <button class="bg-blue-500 text-white w-full py-1 rounded-full hover:bg-blue-600">Create Post</button>
        </div>
        <div class="bg-white rounded-md shadow-md p-4">
            <h2 class="text-lg font-semibold mb-2">Redditlike Rules</h2>
            <ol class="list-decimal list-inside text-sm">
                <li class="mb-2">Be respectful to others</li>
                <li class="mb-2">No spam or self-promotion</li>
                <li class="mb-2">Use appropriate tags</li>
                <li>Follow content policy</li>
            </ol>
        </div>
    </div>
</main>

<footer class="bg-white mt-8 py-4 border-t border-gray-300">
    <div class="container mx-auto text-center text-sm text-gray-500">
        <p>&copy; 2024 Redditlike. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
