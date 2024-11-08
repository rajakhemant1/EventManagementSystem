@extends('layouts.reviewer')

@section('title', 'Talk Proposals')

@section('content')
<div class="container">
    <h2>All Talk Proposals</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Tags</th>
            </tr>
        </thead>
        <tbody>
            @foreach($talkProposals as $proposal)
            <tr>
                <td>{{ $proposal->title }}</td>
                <td>{{ $proposal->description }}</td>
                <td>
                    @foreach($proposal->tags as $tag)
                        <span class="badge bg-primary">{{ $tag->name }}</span>
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
