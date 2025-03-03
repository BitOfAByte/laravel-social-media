<div class="flex items-center space-x-4 mt-4 text-sm text-gray-500">
    <button class="flex items-center space-x-1 hover:text-gray-700 comment-toggle"
            data-post-id="{{ $post->id }}">
        <i class="far fa-comment"></i>
        <span>{{ $post->comments->count() }} Comments</span>
    </button>

    @auth
        <button class="flex items-center space-x-1 hover:text-gray-700 bookmark-button"
                data-post-id="{{ $post->id }}">
            <i class="far fa-bookmark {{ $post->isSavedByUser(auth()->id()) ? 'fas text-blue-500' : 'far' }}"></i>
            <span>Save</span>
        </button>

        @if(auth()->user()->id === $post->user_id)
            <a href="{{ route('posts.edit', $post->id) }}"
               class="flex items-center space-x-1 hover:text-gray-700">
                <i class="far fa-edit"></i>
                <span>Edit</span>
            </a>

            <form action="{{ route('posts.destroy', $post->id) }}"
                  method="POST"
                  class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="flex items-center space-x-1 hover:text-red-500"
                        onclick="return confirm('Are you sure you want to delete this post?')">
                    <i class="far fa-trash-alt"></i>
                    <span>Delete</span>
                </button>
            </form>
        @endif
    @endauth
</div>
