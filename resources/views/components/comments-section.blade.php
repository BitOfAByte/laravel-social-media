<div class="comments-section mt-4" id="comments-{{ $post->id }}">
    @auth
        <form class="mb-4 comment-form" data-post-id="{{ $post->id }}">
            @csrf
            <div class="flex items-start space-x-2">
                <textarea name="comment"
                          class="flex-grow p-2 border rounded-md focus:outline-none focus:border-blue-500"
                          rows="2"
                          placeholder="Write a comment..."></textarea>
                <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Comment
                </button>
            </div>
        </form>
    @endauth

    <div class="comments-container">
        @foreach($comments as $comment)
            <div class="comment bg-gray-50 p-3 rounded-md mb-2">
                <div class="flex items-center space-x-2 text-sm text-gray-500 mb-1">
                    <span class="font-medium">{{ $comment->user->username }}</span>
                    <span>•</span>
                    <span>{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-gray-700">{{ $comment->comment }}</p>

                @auth
                    @if(auth()->user()->id === $comment->user_id)
                        <div class="flex items-center space-x-2 mt-2 text-xs text-gray-500">
                            <button class="edit-comment hover:text-blue-500"
                                    data-comment-id="{{ $comment->id }}">
                                <i class="far fa-edit"></i> Edit
                            </button>
                            <form action="{{ route('comments.destroy', $comment->id) }}"
                                  method="POST"
                                  class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="hover:text-red-500"
                                        onclick="return confirm('Are you sure you want to delete this comment?')">
                                    <i class="far fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        @endforeach
    </div>
</div>
