<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Reddit Clone</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-100">

@include('components.flash-messages')

@include('components.navigation')

<div class="container mx-auto flex mt-4">
    <!-- Main Content -->
    <div class="w-3/4">
        @yield('content')
    </div>

    <!-- Sidebar -->
    <div class="w-1/4 ml-4">
        @include('components.sidebar')
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
