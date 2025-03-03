<div class="flex-1 mx-8">
    <form action="{{ route('search.user') }}" method="GET" class="relative group">
        <input type="text"
               name="q"
               placeholder="Search users..."
               class="w-full px-5 py-2.5 text-gray-700 bg-gray-50 border border-gray-200 rounded-full
                      focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-200
                      transition-all duration-200 ease-in-out
                      placeholder-gray-400"
               value="{{ request('q') }}">
        <button type="submit"
                class="absolute right-4 top-1/2 transform -translate-y-1/2
                       text-gray-400 hover:text-red-500 transition-colors duration-200">
            <i class="fas fa-search text-lg"></i>
        </button>
    </form>
</div>
