<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Follow User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200">
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Follow User</h1>
        <form action="{{ route('follow', ['id' => $user->id]) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600">Follow</button>
        </form>
    </div>
</body>
</html>
