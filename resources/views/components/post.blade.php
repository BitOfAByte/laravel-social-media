<div class="bg-white rounded-md shadow-md mb-4 flex" data-post-id="{{ $post->id }}">
    @include('components.vote-buttons', ['post' => $post])
    <div class="p-4 flex-grow">
        <div class="text-xs text-gray-500 mb-1">
            Posted by {{ $post->user->username }} {{ $post->created_at->diffForHumans() }}
        </div>
        <h2 class="text-lg font-semibold mb-2">{{ $post->title }}</h2>
        <p class="text-sm text-gray-700">{{ $post->content }}</p>
        @include('components.post-actions', ['post' => $post])
        @include('components.comments-section', ['comments' => $post->comments])
    </div>
</div>

