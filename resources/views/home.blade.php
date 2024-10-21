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
            @if(request()->isLoggedIn)
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded-full hover:bg-blue-600">Log Out</button>
                </form>
            @else
                <a href="{{route('login')}}" class="bg-blue-500 text-white px-4 py-1 rounded-full hover:bg-blue-600">Log In</a>
                <a href="{{route('register')}}" class="bg-gray-300 text-blue-500 px-4 py-1 rounded-full ml-2 hover:bg-gray-400">Sign Up</a>
            @endif
        </div>
    </div>
</nav>

<!-- Rest of the home.blade.php content remains the same -->

</body>
</html>
