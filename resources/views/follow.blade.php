@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Follow User</h1>
        <form action="{{ route('follow', ['id' => $user->id]) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Follow</button>
        </form>
    </div>
@endsection
