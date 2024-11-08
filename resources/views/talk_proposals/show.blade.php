@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Talk Proposal Details</h2>
    <p><strong>Title:</strong> {{ $talkProposal->title }}</p>
    <p><strong>Description:</strong> {{ $talkProposal->description }}</p>
   
    @if($talkProposal->tags->isNotEmpty())
        <p><strong>Tags:</strong>
            @foreach($talkProposal->tags as $tag)
                <span class="badge bg-primary">{{ $tag->name }}</span>
            @endforeach
        </p>
    @else
        <p><strong>Tags:</strong> None</p>
    @endif

    @if($talkProposal->file_path)
        <p><strong>Presentation PDF:</strong> <a href="{{ asset('storage/' . $talkProposal->file_path) }}" target="_blank">Download PDF</a></p>
    @endif

    <a href="{{ route('talk-proposals.index') }}" class="btn btn-secondary">Back to Proposals</a>
</div>
@endsection
