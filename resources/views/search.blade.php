<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200">
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Search Results</h1>
    @if($users->isEmpty())
        <p>No users found.</p>
    @else
        <ul>
            @foreach($users as $user)
                <li>{{ $user->username }}</li>
            @endforeach
        </ul>
    @endif
</div>
</body>
</html>
