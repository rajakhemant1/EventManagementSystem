@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">My Talk Proposals</h2>

    <!-- Search Form -->
    <form action="{{ route('talk-proposals.index') }}" method="GET" class="d-flex align-items-center mb-4">
        <div class="flex-grow-1">
            <label for="tags" class="form-label">Search by Tags</label>
            <input type="text" name="tags" id="tags" class="form-control" placeholder="Enter tags separated by commas" value="{{ $search_input }}">
        </div>
        <button type="submit" class="btn btn-primary ms-3 mt-4">Search</button>
    </form>

    <!-- Create Proposal Button -->
    <div class="mb-4 text-end">
        <a href="{{ route('talk-proposals.create') }}" class="btn btn-success">Create New Proposal</a>
    </div>

    <!-- Talk Proposals Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Tags</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($talkProposals as $proposal)
                <tr>
                    <td>{{ $proposal->title }}</td>
                    <td>{{ $proposal->description }}</td>
                    <td>
                        @if($proposal->tags->isNotEmpty())
                            @foreach($proposal->tags as $tag)
                                <span class="badge badge-primary">{{ $tag->name }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">No tags</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('talk-proposals.show', $proposal->id) }}" class="btn btn-info btn-sm me-2">View</a>
                        <a href="{{ route('talk-proposals.edit', $proposal->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                        <form action="{{ route('talk-proposals.destroy', $proposal->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No data found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
