<div class="w-10 bg-gray-100 rounded-l-md flex flex-col items-center py-2">
    @auth
        <button type="button"
                class="vote-button upvote {{ $post->userVoteType === 1 ? 'text-orange-500' : 'text-gray-500' }}"
                data-post-id="{{ $post->id }}"
                data-vote-type="1">
            <i class="fas fa-arrow-up"></i>
        </button>

        <span class="vote-count text-sm font-semibold my-1" data-post-id="{{ $post->id }}">
            {{ $post->votes_sum_vote_type ?? 0 }}
        </span>

        <button type="button"
                class="vote-button downvote {{ $post->userVoteType === -1 ? 'text-blue-500' : 'text-gray-500' }}"
                data-post-id="{{ $post->id }}"
                data-vote-type="-1">
            <i class="fas fa-arrow-down"></i>
        </button>
    @else
        <a href="{{ route('login') }}" class="text-gray-500">
            <i class="fas fa-arrow-up"></i>
        </a>

        <span class="text-sm font-semibold my-1">
            {{ $post->votes_sum_vote_type ?? 0 }}
        </span>

        <a href="{{ route('login') }}" class="text-gray-500">
            <i class="fas fa-arrow-down"></i>
        </a>
    @endauth
</div>
