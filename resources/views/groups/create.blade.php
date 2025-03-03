@extends('layouts.grouplayout')

@section('content')
<div class="container">
    <h2 class="mb-4">Create New Group</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('groups.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Group Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Group</button>
        <a href="{{ route('groups.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
