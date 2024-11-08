@extends('layouts.reviewer')

@section('title', 'Reviewer Dashboard')

@section('content')
<div class="container">
    <h2>Reviewer Dashboard</h2>
    <p>Filter and review talk proposals.</p>

    <!-- Filter Form -->
    <form action="{{ route('reviewer.dashboard') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by title or description">
            </div>
            <div class="col-md-3">
                <select name="tag" class="form-control">
                    <option value="">Filter by Tag</option>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" name="speaker_name" value="{{ request('speaker_name') }}" class="form-control" placeholder="Search by speaker name">
            </div>
            <div class="col-md-3">
                <input type="date" name="date_submitted" value="{{ request('date_submitted') }}" class="form-control" placeholder="Filter by date">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Filter</button>
    </form>

    <!-- Talk Proposals List -->
    <div class="mt-4">
        @foreach($talkProposals as $proposal)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $proposal->title }}</h5>
                    <p class="card-text">{{ $proposal->description }}</p>
                    <p><strong>Tags:</strong>
                        @foreach($proposal->tags as $tag)
                            <span class="badge bg-primary">{{ $tag->name }}</span>
                        @endforeach
                    </p>
                    <p><strong>Speaker:</strong> {{ $proposal->speaker->name }}</p>
                    <p><strong>Submitted on:</strong> {{ $proposal->created_at->format('Y-m-d') }}</p>

                    <!-- Display Existing Reviews or Add Review Button -->
                    @php $existingReview = $proposal->reviews->where('reviewer_id', Auth::id())->first(); @endphp
                    @if ($existingReview)
                        <p><strong>Your Rating:</strong> {{ $existingReview->rating }} / 5</p>
                        <p><strong>Your Comments:</strong> {{ $existingReview->comments }}</p>
                        <button class="btn btn-secondary" data-toggle="modal" data-target="#reviewModal{{ $proposal->id }}">Edit Review</button>
                    @else
                        <button class="btn btn-primary" data-toggle="modal" data-target="#reviewModal{{ $proposal->id }}">Add Review</button>
                    @endif
                </div>
            </div>

            <!-- Review Modal for Adding/Editing Review -->
            <div class="modal fade" id="reviewModal{{ $proposal->id }}" tabindex="-1" aria-labelledby="reviewModalLabel{{ $proposal->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reviewModalLabel{{ $proposal->id }}">Review Proposal: {{ $proposal->title }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('reviewer.talk-proposals.review', $proposal->id) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="rating">Rating (1-5):</label>
                                    <input type="number" name="rating" id="rating" class="form-control" min="1" max="5" required
                                        value="{{ $existingReview->rating ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="comments">Comments:</label>
                                    <textarea name="comments" id="comments" class="form-control">{{ $existingReview->comments ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Review</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $talkProposals->links() }}
    </div>
</div>

<!-- Bootstrap JS and dependencies for modals -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
