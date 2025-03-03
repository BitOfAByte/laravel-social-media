<div class="flex items-center space-x-6">
    @auth
        <a href="{{ route('posts.create') }}"
           class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600
                  transform hover:scale-105 transition-all duration-200
                  shadow-md hover:shadow-lg">
            <i class="fas fa-plus mr-2"></i>Create Post
        </a>
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                    class="flex items-center space-x-3 group">
                <img src="{{ auth()->user()->avatar ?? asset('images/default-avatar.png') }}"
                     alt="Profile"
                     class="w-10 h-10 rounded-full border-2 border-transparent
                            group-hover:border-red-500 transition-all duration-200">
                <span class="hidden md:inline font-medium text-gray-700
                           group-hover:text-red-500 transition-colors duration-200">
                    {{ auth()->user()->name }}
                </span>
                <i class="fas fa-chevron-down text-xs text-gray-400
                         group-hover:text-red-500 transition-colors duration-200"></i>
            </button>
            <div @click.away="open = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 class="absolute right-0 mt-3 w-56 bg-white rounded-lg shadow-xl py-2
                        border border-gray-100">
                <a href="{{ route('user.profile', ['username' => auth()->user()->username]) }}"
                   class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-user mr-3 text-gray-400"></i>
                    <span class="text-gray-700">Profile</span>
                </a>
                <a href="{{ route('users.edit', ['id' => auth()->id()]) }}"
                   class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-cog mr-3 text-gray-400"></i>
                    <span class="text-gray-700">Settings</span>
                </a>
                <hr class="my-1 border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center w-full px-4 py-3 hover:bg-gray-50
                                   transition-colors duration-200 text-red-500 hover:text-red-600">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="flex items-center space-x-4">
            <a href="{{ route('login') }}"
               class="text-gray-600 hover:text-red-500 font-medium
                      transition-colors duration-200">
                Login
            </a>
            <a href="{{ route('register') }}"
               class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600
                      transform hover:scale-105 transition-all duration-200
                      shadow-md hover:shadow-lg font-medium">
                Sign Up
            </a>
        </div>
    @endauth
</div>
