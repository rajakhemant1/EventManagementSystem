@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $speaker->name }}</h1>
    <p>{{ $speaker->bio }}</p>
    <p>Email: {{ $speaker->email }}</p>
</div>
@endsection
