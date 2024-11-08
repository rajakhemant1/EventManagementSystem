@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome to Your Dashboard, {{ Auth::user()->name }}</h1>
    <p>This is your personal dashboard where you can manage your talk proposals.</p>
    <a href="{{ route('talk-proposals.index') }}" class="btn btn-primary">View My Talk Proposals</a>
</div>
@endsection
