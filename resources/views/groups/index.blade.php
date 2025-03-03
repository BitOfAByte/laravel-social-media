@extends('layouts.grouplayout')

@section('content')
<div class="container">
    <h2 class="mb-4">Groups</h2>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <a href="{{ route('groups.create') }}" class="btn btn-primary mb-3">Create New Group</a>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($groups as $group)
        <tr>
            <td>{{ $group->id }}</td>
            <td>{{ $group->name }}</td>
            <td>
                <!-- Delete Form -->
                <form action="{{ route('groups.destroy', $group->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this group?')">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

    @if($groups->isEmpty())
    <p class="text-center text-muted">No groups found.</p>
    @endif
</div>
@endsection
