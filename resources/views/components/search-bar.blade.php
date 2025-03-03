<div class="flex-1 mx-4">
    <form action="{{ route('search.user') }}" method="GET" class="relative">
        <input type="text"
               name="q"
               placeholder="Search users..."
               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-red-500"
               value="{{ request('q') }}">
        <button type="submit" class="absolute right-3 top-2 text-gray-400">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>
