@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-semibold mb-4">Notifications</h1>
        <div class="bg-white rounded-md shadow-md p-4">
            @if($notifications->isEmpty())
                <p>No notifications available.</p>
            @else
                <ul>
                    @foreach($notifications as $userNotification)
                        <li class="mb-2 {{ $userNotification->read_status == 'unread' ? 'font-bold' : '' }}">
                            {{ $userNotification->notification->message }}
                            <span class="text-sm text-gray-500">{{ $userNotification->notification->sent_at->diffForHumans() }}</span>
                            @if($userNotification->read_status == 'unread')
                                <form action="{{ route('notifications.markAsRead', $userNotification->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-blue-500 ml-2">Mark as read</button>
                                </form>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
