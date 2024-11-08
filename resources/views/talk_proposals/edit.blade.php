@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Talk Proposal</h2>
    <form action="{{ route('talk-proposals.update', $talkProposal->id) }}"  id="proposalForm" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $talkProposal->title }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required>{{ $talkProposal->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="tags" class="form-label">Tags</label>
            <select name="tags[]" id="tags" class="form-control" multiple>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" 
                        {{ $talkProposal->tags->contains($tag->id) ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
            <small class="form-text text-muted">Select one or more tags for this talk proposal.</small>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">Upload PDF Presentation (optional)</label>
            <input type="file" class="form-control" id="file" name="file" accept=".pdf">
            <small class="form-text text-muted">Maximum file size: 2MB. Allowed format: PDF</small>
        </div>

        @if($talkProposal->file_path)
            <p>Current File: <a href="{{ asset('storage/' . $talkProposal->file_path) }}" target="_blank">View PDF</a></p>
        @endif

        <button type="submit" class="btn btn-primary">Update Proposal</button>
    </form>
</div>
@endsection
