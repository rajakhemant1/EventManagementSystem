@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Talk Proposal</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('talk-proposals.store') }}" method="POST" id="proposalForm" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" >
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" ></textarea>
        </div>
        <div class="mb-3">
            <label for="tags" class="form-label">Tags</label>
            <select name="tags[]" id="tags" class="form-control" multiple>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Select one or more tags for this talk proposal.</small>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">Upload PDF Presentation (optional)</label>
            <input type="file" class="form-control" id="file" name="file" accept=".pdf">
            <small class="form-text text-muted">Maximum file size: 2MB. Allowed format: PDF</small>
        </div>
        <button type="submit" class="btn btn-primary">Create Proposal</button>
    </form>
</div>
@endsection
